<?php
/**
 * 所有店铺首页 好商城v3 33hao.com
 */

//use shopnc\Tpl;

defined('InShopNC') or exit('Access Invalid!');


class toolControl extends mobileHomeControl {

    public function __construct(){
        parent::__construct();
    }
    

    public function upxmlOp($param) {
    $data = file_get_contents('/Applications/MAMP/htdocs/33hao/data/upload/store/header/04962594135272242.png');
   // var_dump($data);
$http_entity_body = $data;
$http_entity_type = 'application/x-www-form-urlencoded';
$http_entity_length = strlen($http_entity_body);
$host = '192.168.31.250';
$port = 80;
$path = '/33hao/mobile/index.php?act=tool&op=form_image_upload&img_use_type=dc_requirement&user_id=1';
$fp = fsockopen($host, $port, $error_no, $error_desc, 30);
if ($fp)
{
    fputs($fp, "POST {$path} HTTP/1.1\r\n");
    fputs($fp, "Host: {$host}\r\n");
    fputs($fp, "Accept-Type: {$host}\r\n");
    fputs($fp, "Content-Type: {$http_entity_type}\r\n");
    fputs($fp, "Content-Length: {$http_entity_length}\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $http_entity_body . "\r\n\r\n");

    while (!feof($fp))
    {
        $d .= fgets($fp, 4096);
    }
    fclose($fp);
    echo $d;
}

    }
        //ajax上传头像
    	public function image_uploadOp(){
            error_reporting(E_ALL);

            
                $xmlstr= file_get_contents("php://input");
    $filename=time().'.png';
    $timestrap=time();
                $img_path = BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$timestrap.'.png';
    if(file_put_contents($img_path,$xmlstr))
    {
        echo $img_path;
    }
    else
    {
        echo 'failed';
    }
    exit();
    
    
                $img_content = file_get_contents('php://input', 'r'); 
		//$upload = new UploadFile();
		//$upload->set('default_dir',ATTACH_HEADER);
               // $img_name=ATTACH_HEADER;
                $timestrap=time();
                $img_path = BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$timestrap.'.png';
		//$upload->set('max_size',C('image_max_filesize'));
//                $empty=!empty($GLOBALS["HTTP_RAW_POST_DATA"]);
//                if ($empty)
//                {
//                    $img_path = '/Applications/MAMP/htdocs/33hao/data/upload/store/header/'.$timestrap.'.png';
//                  $jpg = $GLOBALS["HTTP_RAW_POST_DATA"];//得到post过来的二进制原始数据
//                  $file = fopen($img_path,"w");//打开文件准备写入
//                  fwrite($file,$jpg);//写入
//                  fclose($file);//关闭
//                }


		//$result = $upload->upfile($raw_post_data['id']);
                $length=file_put_contents($img_path,$img_content);
                
                output_data(array('path'=>$img_path,'length'=>$length));
//		$output	= array();
//		if(!$result){
//			/**
//			 * 转码
//			 */
//			if (strtoupper(CHARSET) == 'GBK'){
//				$upload->error = Language::getUTF8($upload->error);
//			}
//			$output['error']	= $upload->error;
//                         output_data($output);
//			//echo json_encode($output);die;
//		}
//
//		
//
//		/**
//		 * 模型实例化
//		 */
//		$model_upload = Model('upload');
//
//		if(intval($raw_post_data['file_id']) > 0){
//			$file_info = $model_upload->getOneUpload($raw_post_data['file_id']);
//			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$file_info['file_name']);
//
//			$update_array	= array();
//			$update_array['upload_id']	= intval($raw_post_data['file_id']);
//			$update_array['file_name']	= $img_path;
//			$update_array['file_size']	= $_FILES[$raw_post_data['id']]['size'];
//			$model_upload->update($update_array);
//
//			$output['file_id']	= intval($raw_post_data['file_id']);
//			$output['id']		= $raw_post_data['id'];
//			$output['file_name']	= $img_path;
//			//echo json_encode($output);die;
//                         output_data($output);
//		}else{
//			/**
//			 * 图片数据入库
//			 */
//			$insert_array = array();
//			$insert_array['file_name']		= $img_path;
//			$insert_array['upload_type']	= '3';
//			$insert_array['file_size']		= $_FILES[$raw_post_data['id']]['size'];
//			$insert_array['item_id']		= $_SESSION['store_id'];
//			$insert_array['upload_time']	= time();
//
//			$result = $model_upload->add($insert_array);
//
//			if(!$result){
//				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$img_path);
//				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
//				echo json_encode($output);die;
//			}
//
//			$output['file_id']	= $result;
//			$output['id']		= $raw_post_data['id'];
//			$output['file_name']	= $img_path;
//                         output_data($output);
//			//echo json_encode($output);die;
//		}
	}
        
        
        
    public function image_upload_formOp(){
            error_reporting(E_ALL);

//            
//                $xmlstr= file_get_contents("php://input");
//    $filename=time().'.png';
//    $timestrap=time();
//                $img_path = BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$timestrap.'.png';
//    if(file_put_contents($img_path,$xmlstr))
//    {
//        echo $img_path;
//    }
//    else
//    {
//        echo 'failed';
//    }
//    exit();
//    
    
                $img_content = file_get_contents('php://input', 'r'); 
		$upload = new UploadFile();
		$upload->set('default_dir',ATTACH_HEADER);
               // $img_name=ATTACH_HEADER;
               // $timestrap=time();
               // $img_path = BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$timestrap.'.png';
		$upload->set('max_size',C('image_max_filesize'));
//                $empty=!empty($GLOBALS["HTTP_RAW_POST_DATA"]);
//                if ($empty)
//                {
//                    $img_path = '/Applications/MAMP/htdocs/33hao/data/upload/store/header/'.$timestrap.'.png';
//                  $jpg = $GLOBALS["HTTP_RAW_POST_DATA"];//得到post过来的二进制原始数据
//                  $file = fopen($img_path,"w");//打开文件准备写入
//                  fwrite($file,$jpg);//写入
//                  fclose($file);//关闭
//                }


		$result = $upload->upfile($_POST['id']);
               // $length=file_put_contents($img_path,$img_content);
                
               // output_data(array('path'=>$img_path,'length'=>$length));
//		$output	= array();
		if(!$result){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output['error']	= $upload->error;
                         output_data($output);
			//echo json_encode($output);die;
		}
//
//		
//
//		/**
//		 * 模型实例化
//		 */
		$model_upload = Model('upload');

		if(intval($raw_post_data['file_id']) > 0){
			$file_info = $model_upload->getOneUpload($raw_post_data['file_id']);
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$file_info['file_name']);

			$update_array	= array();
			$update_array['upload_id']	= intval($raw_post_data['file_id']);
			$update_array['file_name']	= $img_path;
			$update_array['file_size']	= $_FILES[$raw_post_data['id']]['size'];
			$model_upload->update($update_array);

			$output['file_id']	= intval($raw_post_data['file_id']);
			$output['id']		= $raw_post_data['id'];
			$output['file_name']	= $img_path;
			//echo json_encode($output);die;
                         output_data($output);
		}else{
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name']		= $img_path;
			$insert_array['upload_type']	= '3';
			$insert_array['file_size']		= $_FILES[$raw_post_data['id']]['size'];
			$insert_array['item_id']		= $_SESSION['store_id'];
			$insert_array['upload_time']	= time();

			$result = $model_upload->add($insert_array);

			if(!$result){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$img_path);
				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
				echo json_encode($output);die;
			}

			$output['file_id']	= $result;
			$output['id']		= $raw_post_data['id'];
			$output['file_name']	= $img_path;
                         output_data($output);
			//echo json_encode($output);die;
		}
	}

	/**
	 * ajax删除头像
	 */
	public function dorp_imgOp(){
		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		$file_info = $model_upload->getOneUpload(intval($_REQUEST['file_id']));
		if(!$file_info){
		}else{
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$file_info['file_name']);
			$model_upload->del(intval($_REQUEST['file_id']));
		}
                output_data(array('succeed'=>'1'));
		//echo json_encode(array('succeed'=>Language::get('nc_common_save_succ','UTF-8')));die;
	}


        
        public function form_image_uploadOp(){
            
		$upload = new UploadFile();
                
                switch ($_REQUEST['img_use_type']) {
                    case 'dc_requirement':
                        $dir=ATTACH_REQUEST.'/'.$_REQUEST['user_id'].'/';
                        break;
                    case 'member_avatar':
                        $dir=ATTACH_AVATAR.'/'.$_REQUEST['user_id'].'/';
                        break;
                    
                    default:
                        break;
                }
		$upload->set('default_dir',$dir);
		$upload->set('max_size',C('image_max_filesize'));
                        $upload->set('thumb_width', GOODS_IMAGES_WIDTH);
        $upload->set('thumb_height', GOODS_IMAGES_HEIGHT);
        $upload->set('thumb_ext', GOODS_IMAGES_EXT);
        $upload->set('fprefix', $_REQUEST['user_id']);
             //   output_error(C('image_max_filesize'));
		//$result = $upload->upfile($_POST['id']);
                $result = $upload->upfile('image');
		$output	= array();
		if(!$result){
			/**
			 * 转码
			 */
			if (strtoupper(CHARSET) == 'GBK'){
				$upload->error = Language::getUTF8($upload->error);
			}
			$output['error']	= $upload->error;
                        output_error($upload->error);
			//echo json_encode($output);die;
		}

		$img_path = $upload->file_name;

		/**
		 * 模型实例化
		 */
		$model_upload = Model('upload');
		if(intval($_POST['file_id']) > 0){
			$file_info = $model_upload->getOneUpload($_REQUEST['file_id']);
			@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$file_info['file_name']);

			$update_array	= array();
			$update_array['upload_id']	= intval($_REQUEST['file_id']);
			$update_array['file_name']	= $img_path;
			//$update_array['file_size']	= $_FILES[$_POST['id']]['size'];
                        $update_array['file_size']	= $_FILES['image']['size'];
			$model_upload->update($update_array);

			$output['file_id']	= intval($_REQUEST['file_id']);
			//$output['id']		= $_POST['id'];
                        $output['id']		= 'image';
			$output['file_name']	= $img_path;
                        output_data($output);
			//echo json_encode($output);die;
		}else{
			/**
			 * 图片数据入库
			 */
			$insert_array = array();
			$insert_array['file_name']		= $img_path;
			$insert_array['upload_type']	= '3';
			//$insert_array['file_size']		= $_FILES[$_POST['id']]['size'];
                        $insert_array['file_size']		= $_FILES['image']['size'];
			$insert_array['item_id']		= 1;
			$insert_array['upload_time']	= time();

			$result = $model_upload->add($insert_array);

			if(!$result){
				@unlink(BASE_UPLOAD_PATH.DS.ATTACH_HEADER.DS.$img_path);
				$output['error']	= Language::get('store_slide_upload_fail','UTF-8');
				output_error(Language::get('store_slide_upload_fail','UTF-8'));
                                //echo json_encode($output);die;
			}

			$output['file_id']	= $result;
			$output['file_name']	= $img_path;
                        output_data($output);
			//echo json_encode($output);die;
		}
	}
        
}