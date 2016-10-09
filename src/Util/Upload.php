<?php

namespace shihunguilai\phpapi\Util;

class Upload
{
    private $upload_dir; //保存的文件的目录
    private $allow_ext = array(); //允许的文件类型  空数组 不限制
    private $must_real_pic = false; //是否必须为真的图片
    private $max_file_size = 0; //文件最大  ,0不限制
    private $upload_files = array(); //处理单文件、多文件上传

    private $error_msg = array();

    public function __construct($upload_dir, $allow_ext = array(), $must_real_pic = false, $max_file_size = 0)
    {
        $this->upload_dir = $upload_dir;
        $this->allow_ext = $allow_ext;
        $this->must_real_pic = $must_real_pic;
        $this->max_file_size = $max_file_size;
    }

    /**
     * 获取 多文件 、单文件的上传.
     *
     * 2016-3-1-下午2:58:08
     */
    public function getUploadFiles()
    {
        if (empty($_FILES)) {
            return;
        }
        foreach ($_FILES as $v) {
            if (is_array($v['name'])) {
                //多文件上传
                foreach ($v['name'] as $key => $value) {
                    $this->upload_files[] = array(
                        'name' => $value,
                        'size' => $v['size'][$key],
                        'type' => $v['type'][$key],
                        'tmp_name' => $v['tmp_name'][$key],
                        'error' => $v['error'][$key],
                    );
                }
            } else { //单文件上传
                $this->upload_files[] = array(
                    'name' => $v['name'],
                    'size' => $v['size'],
                    'type' => $v['type'],
                    'tmp_name' => $v['tmp_name'],
                    'error' => $v['error'],
                );
            }
        }
    }

    /**
     * 处理上传逻辑.
     *
     * 2016-3-1-下午2:57:48
     */
    public function doUPload()
    {
        $this->getUploadFiles();
// 		print_r($this->upload_files);
        if (empty($this->upload_files)) {
            $this->error_msg[] = '没有上传任何文件';

            return false;
        }

        $ret = array();

        //循环处理 上传 文件 逻辑
        foreach ($this->upload_files as $val) {
            switch ($val['error']) {
                case UPLOAD_ERR_OK:{//0,没有错误发生，文件上传成功
                    break;
                }
                case UPLOAD_ERR_INI_SIZE:{//1,上传的文件超过了 php.ini中upload_max_filesize(默认情况为2M) 选项限制的值
                    $this->error_msg[] = "{$val['name']},文件大小超过了系统允许上传的最大值";
                    continue;
                    break;
                }
                case UPLOAD_ERR_FORM_SIZE:{//2:上传文件的大小超过了 HTML表单中MAX_FILE_SIZE选项指定的值
                    $this->error_msg[] = "{$val['name']},文件大小超过了表单系统允许上传的最大值";
                    continue;
                    break;
                }
                case UPLOAD_ERR_PARTIAL:{//3:文件只有部分被上传
                    $this->error_msg[] = "{$val['name']},文件只有部分被上传，请重新上传";
                    continue;
                    break;
                }
                case UPLOAD_ERR_NO_FILE:{//4:没有文件被上传
                    $this->error_msg[] = '没有文件被上传';
                    continue;
                    break;
                }
                case 5:{//传文件大小为0
                    $this->error_msg[] = "{$val['name']},文件大小为0";
                    continue;
                    break;
                }
            }

            if (!is_uploaded_file($val['tmp_name'])) {
                $this->error_msg[] = "{$val['name']},不是通过http post 方式 上传的";
                continue;
            }

            if ($this->must_real_pic && !$this->is_real_pic($val['tmp_name'])) {
                $this->error_msg[] = "{$val['name']},不是真正的图片";
                continue;
            }

            $file_ext = $this->get_file_extension($val['name']);
            if (!empty($this->allow_ext)) {
                if (!in_array($file_ext, $this->allow_ext)) {
                    $this->error_msg[] = "{$val['name']},是不允许上传的 文件类型";
                    continue;
                }
            }

            $file_name = $this->upload_dir.DIRECTORY_SEPARATOR.$this->getUniqueFileName().'.'.$file_ext;

            if (!move_uploaded_file($val['tmp_name'], $file_name)) {
                $this->error_msg[] = "{$val['name']},上传失败";
                continue;
            }

            $ret[] = $file_name;
        }

        $ret = array_merge($ret, $this->error_msg);

        return $ret;
    }

    public function getError()
    {
        return $this->error_msg;
    }

    public function getUniqueFileName()
    {
        return md5(uniqid(md5(microtime(true)), true));
    }

    /**
     * 判断是否为真正的图片.
     *
     * @param unknown $pic
     *
     * @return bool
     *              2016-3-2-上午10:55:22
     */
    public function is_real_pic($pic)
    {
        $real_path = realpath($pic);
        $tp = getimagesize($real_path);
        if ($tp === false) {
            return false;
        }

        return true;
    }

    /**
     * 获取文件 扩展名.
     *
     * 2016-3-2-下午2:57:23
     */
    public function get_file_extension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }
}
