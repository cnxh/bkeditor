<?php
/**
 * ��ʽ��CSS�ļ���ȥ��CSS�ļ����ݵ��еĿո�
 */
function format_css($inFile, $name){
	$style = file_get_contents($inFile);
	$style = preg_replace("/\s*([{;:])\s*/",'$1',$style);
	$style = preg_replace("/\s+\}/","}",$style);
	$style = preg_replace("/\}\s+/","}\n",$style);
	
	$style = preg_replace("/ +/",' ',$style);
	$style = preg_replace("/;\}/",'}',$style);
	
	$style_list=explode("\n", $style);
	$style_json=json_encode($style_list);
	
	return "\n(function(E){E.$name=$style_json;})(jQEditor);";
}

/**
 * ��ȡ�ļ�����
 * @param string|array $file|$file_list
 *		�ļ������ļ�������
 * @return string
 */
function read_file($file){
	if(is_string($file) && is_file($file)){
	//��ȡһ���ļ�
		return file_get_contents($file);
	}else if(is_array($file)){
	//��ȡһ���ļ����飬��������������һ�𷵻�
		$s='';
		foreach($file as $f){
			$f = trim($f);
			if( is_file($f)){
				$s .= file_get_contents($f);
			}else if($f){
				echo "$f<br>";
			}
		}
		
		return $s;
	}else{
	//�������ش���
		return 0;
	}
}