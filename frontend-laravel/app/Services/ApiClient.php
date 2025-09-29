<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class ApiClient {
  private string $base;
  public function __construct(){ $this->base = rtrim(env('API_BASE'), '/'); }
  public function get($p,$q=[]){ return Http::acceptJson()->get("$this->base/$p",$q)->json(); }
  public function postJson($p,$d=[]){ return Http::acceptJson()->asJson()->post("$this->base/$p",$d)->json(); }
  public function putJson($p,$d=[]){ return Http::acceptJson()->asJson()->put("$this->base/$p",$d)->json(); }
  public function delete($p){ return Http::acceptJson()->delete("$this->base/$p")->json(); }
  public function postMultipart($p,$fields,$files=[]){
    $req=Http::asMultipart();
    foreach($fields as $k=>$v){ $req=$req->attach($k,(string)$v); }
    foreach($files as $k=>$f){ $req=$req->attach($k,file_get_contents($f->getRealPath()),$f->getClientOriginalName()); }
    return $req->post("$this->base/$p")->json();
  }
}
