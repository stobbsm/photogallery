<?php

namespace App\Http\Controllers;

use Symfony\Component\Console\Output\BufferedOutput;
use Illuminate\Http\Request;

class Tools extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  
  /**
  * Scan the files and add them to the database
  *
  * @return \Illuminate\Http\Response
  */
  public function scanfiles()
  {
    \Artisan::call('photogallery:scan');
    return view('tools.scanfiles', ['output' => \Artisan::output()]);
  }
  
  /**
  * Verify the database as compared to the filesystem
  *
  * @return \Illuminate\Http\Response
  */
  public function verifydb()
  {
    \Artisan::call('photogallery:verifydatabase');
    return view('tools.scanfiles', ['output' => \Artisan::output()]);
  }
}
