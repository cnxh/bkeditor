<?php
/**
 * ����ѹ������
 * ���������jsԴ���css�ļ��������Ϻ�ѹ�������jqeditor-version.min.js
 * js��ѹ��ʹ��google��compiler.jar���ߣ���Ҫ��װ java ���л�����
 * �����������п�ִ��java���
 * compiler.jar ����Ĭ��Ŀ¼ E:\compiler\compiler.jar
 */
set_time_limit(60);

define('BKEDITOR', dirname(dirname(__FILE__)) );

include 'common.php';
include 'config.php';

$source = '';

if( isset($_GET['source']) ){
	$source = $_GET['source'];
}

if(!$source){ $source = 'default'; }

//��ȡjs�ļ�
$script = read_file( file(BKEDITOR."/release/source_{$source}.txt") );

// 2011-07-21 css�ļ����ٺ�js���ϣ���Ϊcss�ļ����еı���ͼƬ·������
	//��ȡcss�ļ�����js�ļ�����
	//$script .= format_css("../skins/content_default.css", 'styleContent');
	//$script .= format_css("../skins/skin_base.css", 'styleBase');

//������ʱ�ļ������н������ɾ��
$tmp_script_file = BKEDITOR."/release/bkeditor_tmp.js";

//����������д����ʱ�ļ�
file_put_contents($tmp_script_file, $script);

//��������ļ�
$out_script_file = BKEDITOR."/min/{$version['min']}/bkeditor-$source.min.js";

//����ѹ���������
$cmd = "java -jar $compiler --js=$tmp_script_file --js_output_file=$out_script_file";
//ִ��ѹ������
exec($cmd, $output);


//��ȡѹ���������
$script=file_get_contents($out_script_file);
if( empty($script) ){
//���û���������ʾ����
	echo $cmd;
	print_r($output);
	exit('error');
}

//���copyrightͷ����д�뵽$out_script_file
file_put_contents($out_script_file, $copyright.$script);

//���
echo 'OK.<br />';

//���compiler����ѹ����������ʾ��Ϣ�������
if(!empty($output)){
	print_r($output);
}

//ɾ����ʱ�ļ�
unlink($tmp_script_file);
