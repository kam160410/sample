<?php

function get_db_config()
{

	if(getenv("IS_IN_HEROKU")) {
		$url = parse_url(getenv('DATABASE_'))
		return [
			'connection' =>  'pgsql',
			'host'       =>   $url['host'],
			'database'   =>   substr($url['path'],1),
			'username'	 =>   $url('user'),
			'password'   =>   $url('pass'),
		];
	}else{
			'connection' =>   env('DB_CONNECTION','sample'),
			'host'       =>   env('DB_HOST','localhost'),
			'database'   =>   env('DB_DATABASE','forget'),
			'username'	 =>   env('DB_USERNAME','forget'),
			'password'   =>   env('DB_PASSWORD','')
	}

}