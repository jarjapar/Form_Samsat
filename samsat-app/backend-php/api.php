<?php
declare(strict_types=1);

// CORS
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { http_response_code(204); exit; }

// CONFIG (aman double-include)
if (!defined('DB_FILE'))    define('DB_FILE', __DIR__.'/db/db.sqlite');
if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', __DIR__.'/uploads');


// Pastikan upload dir ada
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0777, true);
}

// ====== UTIL ======
function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $needInit = !file_exists(DB_FILE);
        $pdo = new PDO('sqlite:' . DB_FILE, null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        if ($needInit) {
            initSchema($pdo);
        }
    }
    return $pdo;
}

function initSchema(PDO $pdo): void {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS samsat(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT NOT NULL,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL
    );

    CREATE TABLE IF NOT EXISTS pengunjung(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT NOT NULL,
        alamat TEXT NOT NULL,
        jenis_kelamin TEXT NOT NULL,
        no_hp TEXT NOT NULL
    );

    CREATE TABLE IF NOT EXISTS berita(
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        judul TEXT NOT NULL,
        isi TEXT NOT NULL,
        gambar TEXT NOT NULL,
        tanggal_post TEXT NOT NULL
    );
    SQL;
    $pdo->exec($sql);
}

function json($data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function readJson(): array {
    $input = file_get_contents('php://input') ?: '';
    $data = json_decode($input, true);
    return is_array($data) ? $data : [];
}

function param(string $key, $default = null) {
    return $_GET[$key] ?? $default;
}

function pathSegments(): array {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($path, PHP_URL_PATH) ?: '/';
    $segs = array_values(array_filter(explode('/', $path), fn($s) => $s !== ''));
    return $segs;
}

function isId($s): bool {
    return ctype_digit((string)$s);
}

function saveUploadedImage(string $fieldName = 'gambar'): string {
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('File gambar wajib diupload');
    }
    $tmp  = $_FILES[$fieldName]['tmp_name'];
    $name = $_FILES[$fieldName]['name'];
    $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
        throw new RuntimeException('Format gambar harus jpg/jpeg/png/webp');
    }
    $new = uniqid('img_', true) . '.' . $ext;
    $dest = UPLOAD_DIR . '/' . $new;
    if (!move_uploaded_file($tmp, $dest)) {
        throw new RuntimeException('Gagal menyimpan file');
    }
    return $new;
}

function likeTerm(?string $q): string {
    return '%' . str_replace(['%', '_'], ['\%','\_'], (string)$q) . '%';
}

function paginate(): array {
    $page  = max(1, (int)param('page', 1));
    $limit = max(1, min(100, (int)param('limit', 20)));
    $offset = ($page - 1) * $limit;
    return [$limit, $offset, $page];
}

// ====== ROUTER ======
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$segs   = pathSegments();

// Root
if (count($segs) === 0) {
    json(['ok' => true, 'message' => 'Samsat API ready']);
}

// ------ AUTH ------
if ($segs[0] === 'auth' && $method === 'POST' && ($segs[1] ?? '') === 'login') {
    $body = readJson();
    $username = trim($body['username'] ?? '');
    $password = trim($body['password'] ?? '');
    if ($username === '' || $password === '') {
        json(['ok' => false, 'error' => 'username/password wajib'], 400);
    }

    $stmt = db()->prepare('SELECT id, nama, username, password FROM samsat WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row || $row['password'] !== $password) { // NOTE: ganti dengan password_hash() untuk produksi
        json(['ok' => false, 'error' => 'Login gagal'], 401);
    }
    json(['ok' => true, 'user' => ['id'=>$row['id'],'nama'=>$row['nama'],'username'=>$row['username']]]);
}

// ------ SAMSAT ------
if ($segs[0] === 'samsat') {
    // GET /samsat
    if ($method === 'GET' && count($segs) === 1) {
        $q = trim((string)param('q',''));
        [$limit,$offset,$page] = paginate();

        if ($q !== '') {
            $stmt = db()->prepare('SELECT * FROM samsat WHERE nama LIKE :t OR username LIKE :t ORDER BY id DESC LIMIT :lim OFFSET :off');
            $stmt->bindValue(':t', likeTerm($q));
        } else {
            $stmt = db()->prepare('SELECT * FROM samsat ORDER BY id DESC LIMIT :lim OFFSET :off');
        }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':off', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total = (int)db()->query('SELECT COUNT(*) FROM samsat')->fetchColumn();
        json(['ok'=>true,'data'=>$rows,'pagination'=>['page'=>$page,'limit'=>$limit,'total'=>$total]]);
    }
    // GET /samsat/{id}
    if ($method === 'GET' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $stmt = db()->prepare('SELECT * FROM samsat WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row ? json(['ok'=>true,'data'=>$row]) : json(['ok'=>false,'error'=>'Not found'],404);
    }
    // POST /samsat
    if ($method === 'POST' && count($segs) === 1) {
        $b = readJson();
        foreach (['nama','username','password'] as $f) {
            if (empty($b[$f])) json(['ok'=>false,'error'=>"$f wajib"],400);
        }
        $stmt = db()->prepare('INSERT INTO samsat(nama,username,password) VALUES(?,?,?)');
        try {
            $stmt->execute([$b['nama'],$b['username'],$b['password']]);
        } catch (PDOException $e) {
            json(['ok'=>false,'error'=>'username sudah dipakai'],409);
        }
        json(['ok'=>true,'id'=> (int)db()->lastInsertId()],201);
    }
    // PUT /samsat/{id}
    if ($method === 'PUT' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $b = readJson();
        $fields = [];
        $vals = [];
        foreach (['nama','username','password'] as $f) {
            if (isset($b[$f]) && $b[$f] !== '') {
                $fields[] = "$f = ?";
                $vals[] = $b[$f];
            }
        }
        if (!$fields) json(['ok'=>false,'error'=>'Tidak ada field diupdate'],400);
        $vals[] = $id;
        $sql = 'UPDATE samsat SET '.implode(', ',$fields).' WHERE id = ?';
        $stmt = db()->prepare($sql);
        $stmt->execute($vals);
        json(['ok'=>true]);
    }
    // DELETE /samsat/{id}
    if ($method === 'DELETE' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $stmt = db()->prepare('DELETE FROM samsat WHERE id=?');
        $stmt->execute([$id]);
        json(['ok'=>true]);
    }
}

// ------ PENGUNJUNG ------
if ($segs[0] === 'pengunjung') {
    if ($method === 'GET' && count($segs) === 1) {
        $q = trim((string)param('q',''));
        [$limit,$offset,$page] = paginate();
        if ($q !== '') {
            $stmt = db()->prepare('SELECT * FROM pengunjung WHERE nama LIKE :t OR alamat LIKE :t OR no_hp LIKE :t ORDER BY id DESC LIMIT :lim OFFSET :off');
            $stmt->bindValue(':t', likeTerm($q));
        } else {
            $stmt = db()->prepare('SELECT * FROM pengunjung ORDER BY id DESC LIMIT :lim OFFSET :off');
        }
        $stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
        $stmt->bindValue(':off',$offset,PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = (int)db()->query('SELECT COUNT(*) FROM pengunjung')->fetchColumn();
        json(['ok'=>true,'data'=>$rows,'pagination'=>['page'=>$page,'limit'=>$limit,'total'=>$total]]);
    }
    if ($method === 'GET' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $stmt = db()->prepare('SELECT * FROM pengunjung WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row ? json(['ok'=>true,'data'=>$row]) : json(['ok'=>false,'error'=>'Not found'],404);
    }
    if ($method === 'POST' && count($segs) === 1) {
        $b = readJson();
        foreach (['nama','alamat','jenis_kelamin','no_hp'] as $f) {
            if (empty($b[$f])) json(['ok'=>false,'error'=>"$f wajib"],400);
        }
        $stmt = db()->prepare('INSERT INTO pengunjung(nama,alamat,jenis_kelamin,no_hp) VALUES(?,?,?,?)');
        $stmt->execute([$b['nama'],$b['alamat'],$b['jenis_kelamin'],$b['no_hp']]);
        json(['ok'=>true,'id'=>(int)db()->lastInsertId()],201);
    }
    if ($method === 'PUT' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $b = readJson();
        $fields = []; $vals = [];
        foreach (['nama','alamat','jenis_kelamin','no_hp'] as $f) {
            if (isset($b[$f]) && $b[$f] !== '') { $fields[]="$f=?"; $vals[]=$b[$f]; }
        }
        if (!$fields) json(['ok'=>false,'error'=>'Tidak ada field diupdate'],400);
        $vals[] = $id;
        $stmt = db()->prepare('UPDATE pengunjung SET '.implode(', ',$fields).' WHERE id=?');
        $stmt->execute($vals);
        json(['ok'=>true]);
    }
    if ($method === 'DELETE' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $stmt = db()->prepare('DELETE FROM pengunjung WHERE id=?');
        $stmt->execute([$id]);
        json(['ok'=>true]);
    }
}

// ------ BERITA ------
if ($segs[0] === 'berita') {
    // List
    if ($method === 'GET' && count($segs) === 1) {
        $q = trim((string)param('q',''));
        $order = param('order','tanggal_post');
        $dir = strtolower((string)param('dir','desc')) === 'asc' ? 'ASC' : 'DESC';
        $allowedOrder = ['tanggal_post','judul','id'];
        if (!in_array($order,$allowedOrder)) $order = 'tanggal_post';
        [$limit,$offset,$page] = paginate();

        if ($q !== '') {
            $stmt = db()->prepare("SELECT * FROM berita WHERE judul LIKE :t OR isi LIKE :t ORDER BY $order $dir LIMIT :lim OFFSET :off");
            $stmt->bindValue(':t', likeTerm($q));
        } else {
            $stmt = db()->prepare("SELECT * FROM berita ORDER BY $order $dir LIMIT :lim OFFSET :off");
        }
        $stmt->bindValue(':lim',$limit,PDO::PARAM_INT);
        $stmt->bindValue(':off',$offset,PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$r) {
            $r['gambar_url'] = '/uploads/'.$r['gambar'];
        }
        $total = (int)db()->query('SELECT COUNT(*) FROM berita')->fetchColumn();
        json(['ok'=>true,'data'=>$rows,'pagination'=>['page'=>$page,'limit'=>$limit,'total'=>$total]]);
    }
    // Detail
    if ($method === 'GET' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $stmt = db()->prepare('SELECT * FROM berita WHERE id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $row['gambar_url'] = '/uploads/'.$row['gambar'];
            json(['ok'=>true,'data'=>$row]);
        } else {
            json(['ok'=>false,'error'=>'Not found'],404);
        }
    }
    // Tambah (multipart)
    if ($method === 'POST' && count($segs) === 1) {
        if (strpos($_SERVER['CONTENT_TYPE'] ?? '', 'multipart/form-data') === false) {
            json(['ok'=>false,'error'=>'Gunakan multipart/form-data untuk upload gambar'],415);
        }
        $judul = trim($_POST['judul'] ?? '');
        $isi   = trim($_POST['isi'] ?? '');
        $tgl   = trim($_POST['tanggal_post'] ?? '');
        if ($judul===''||$isi===''||$tgl==='') {
            json(['ok'=>false,'error'=>'judul, isi, tanggal_post wajib'],400);
        }
        try {
            $fileName = saveUploadedImage('gambar');
        } catch (RuntimeException $e) {
            json(['ok'=>false,'error'=>$e->getMessage()],400);
        }
        $stmt = db()->prepare('INSERT INTO berita(judul,isi,gambar,tanggal_post) VALUES(?,?,?,?)');
        $stmt->execute([$judul,$isi,$fileName,$tgl]);
        $id = (int)db()->lastInsertId();
        json(['ok'=>true,'id'=>$id,'gambar_url'=>'/uploads/'.$fileName],201);
    }
    // Update (JSON fields)
    if ($method === 'PUT' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        $b = readJson();
        $fields=[]; $vals=[];
        foreach (['judul','isi','tanggal_post'] as $f) {
            if (isset($b[$f]) && $b[$f] !== '') { $fields[]="$f=?"; $vals[]=$b[$f]; }
        }
        if (!$fields) json(['ok'=>false,'error'=>'Tidak ada field diupdate'],400);
        $vals[] = $id;
        $stmt = db()->prepare('UPDATE berita SET '.implode(', ',$fields).' WHERE id=?');
        $stmt->execute($vals);
        json(['ok'=>true]);
    }
    // Ganti gambar
    if ($method === 'POST' && count($segs) === 3 && isId($segs[1]) && $segs[2]==='gambar') {
        $id = (int)$segs[1];
        try {
            $fileName = saveUploadedImage('gambar');
        } catch (RuntimeException $e) {
            json(['ok'=>false,'error'=>$e->getMessage()],400);
        }
        // hapus file lama (optional)
        $old = db()->prepare('SELECT gambar FROM berita WHERE id=?');
        $old->execute([$id]);
        $prev = $old->fetchColumn();
        if ($prev && file_exists(UPLOAD_DIR.'/'.$prev)) @unlink(UPLOAD_DIR.'/'.$prev);

        $stmt = db()->prepare('UPDATE berita SET gambar=? WHERE id=?');
        $stmt->execute([$fileName,$id]);
        json(['ok'=>true,'gambar_url'=>'/uploads/'.$fileName]);
    }
    // Hapus
    if ($method === 'DELETE' && count($segs) === 2 && isId($segs[1])) {
        $id = (int)$segs[1];
        // hapus file gambar
        $old = db()->prepare('SELECT gambar FROM berita WHERE id=?');
        $old->execute([$id]);
        $prev = $old->fetchColumn();
        if ($prev && file_exists(UPLOAD_DIR.'/'.$prev)) @unlink(UPLOAD_DIR.'/'.$prev);
        $stmt = db()->prepare('DELETE FROM berita WHERE id=?');
        $stmt->execute([$id]);
        json(['ok'=>true]);
    }
}

// ------ STATS ------
if ($segs[0] === 'stats' && $method === 'GET') {
    $pengunjung = (int)db()->query('SELECT COUNT(*) FROM pengunjung')->fetchColumn();
    $berita     = (int)db()->query('SELECT COUNT(*) FROM berita')->fetchColumn();
    $samsat     = (int)db()->query('SELECT COUNT(*) FROM samsat')->fetchColumn();
    json(['ok'=>true,'data'=>compact('pengunjung','berita','samsat')]);
}

// 404
json(['ok'=>false,'error'=>'Endpoint tidak ditemukan'],404);
