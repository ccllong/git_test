<?
function m_cache($func_name, $cache_file_name, $sec , $path="/web/bbs.imeimama.com/cache/"){
    $cache_file_name = $path.$cache_file_name;
    $mark_file_name = $cache_file_name."_mark";
    if(!file_exists($cache_file_name) || (((time() - @filemtime($cache_file_name)) > $sec) && (@file_get_contents($mark_file_name) !=1)) ){
        m_write_file($mark_file_name, '1');
        $needed_data = $func_name();
        m_write_file($cache_file_name, serialize($needed_data));
        m_write_file($mark_file_name, '0');
        return $needed_data;
    }else{
        return $needed_data = unserialize(file_get_contents($cache_file_name));
    }
}

function m_write_file($file_name, $contents){
    $handle = fopen($file_name, 'w');
    fwrite($handle, $contents);
    fclose($handle);
}

function get_url_contents($url)
{
//先判断allow_url_fopen是否打开，如果打开则用file_get_contents获取，如果没打开用curl_init获取
    if (ini_get("allow_url_fopen") == "1"){
        $rs_content = file_get_contents($url);
		if(!$rs_content){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_URL, $url);
			$result =  curl_exec($ch);
			curl_close($ch);
		
			return $result;
		}else{
		    return $rs_content;
		}
	} 
}
  $weather_content = get_url_contents("http://m.weather.com.cn/data/101310201.html");
  var_dump($weather_content);
?>