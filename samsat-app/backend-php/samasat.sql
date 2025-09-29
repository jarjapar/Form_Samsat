-- Tabel admin/operator Samsat
DROP TABLE IF EXISTS samsat;
CREATE TABLE samsat(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT NOT NULL,
    username TEXT NOT NULL,
    password TEXT NOT NULL
);

-- Tabel data pengunjung dan pengaduan
DROP TABLE IF EXISTS pengunjung;
CREATE TABLE pengunjung(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nama TEXT NOT NULL,
    alamat TEXT NOT NULL,
    jenis_kelamin TEXT NOT NULL,
    no_hp TEXT NOT NULL
);

-- Tabel berita untuk web profil
DROP TABLE IF EXISTS berita;
CREATE TABLE berita(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    judul TEXT NOT NULL,
    isi TEXT NOT NULL,
    gambar TEXT NOT NULL,
    tanggal_post TEXT NOT NULL
);
