<?php

namespace App\Http\Controllers;

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
    return view('tools.scanfiles');
  }
  
  /**
  * Verify the database as compared to the filesystem
  *
  * @return \Illuminate\Http\Response
  */
  public function verifydb()
  {
    return view('tools.verify');
  }
}
