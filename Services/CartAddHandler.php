<?php
/**
 * Created by JetBrains PhpStorm.
 * User: volt
 * Date: 01.06.13
 * Time: 12:01
 * To change this template use File | Settings | File Templates.
 */

namespace Baglie\CartBundle\Services;

//use Voltash\UploadBundle\Services\PHPImageWorkshop\ImageWorkshop;


class CartAddHandler
{
    protected $session;
    protected $config;
    protected $sessionAttr;

    public function __construct(\Symfony\Component\HttpFoundation\Session\SessionInterface $session, $config)
    {
        $this->session = $session;
        $this->config = $config;
    }

    public function handleFilesAndSave($field, $dir, $json = false)
    {
        $this->sessionAttr = 'file_upload_'.$field;
        if ($this->session->has($this->sessionAttr))
        {
            $filesInfo = new \SplObjectStorage();
            $filesInfo->unserialize($this->session->get($this->sessionAttr));

            if ($this->config[$filesInfo->type]['type'] == 'file') {
                $result = $this->saveFiles($filesInfo, $dir);
            } elseif ($this->config[$filesInfo->type]['type'] == 'image') {
                $result = $this->saveImages($filesInfo, $dir, $this->config[$filesInfo->type]['thumbnails']);
            } else {
                throw new \Exception('Unrecognized file type!');
            }

            $this->clearSessionAttr();

            if ($json)
                $result = json_encode($result);

            return $result;
        } else {
            return false;
        }
    }

    private function saveFiles($filesInfo, $dir)
    {
        $this->checkDir($dir);

        $result = array();

        // TODO make uniqe files name from config
        foreach ($filesInfo as $file)
        {
            rename($file->path, $dir.'/file.'.$file->extension);
            $result[] = 'file.'.$file->extension;
        }

        return $result;
    }

    private function saveImages($filesInfo, $dir, $thumbs)
    {

        /*$this->checkDir($dir);
        $result = array();
        foreach ($filesInfo as $file)
        {
            foreach ($thumbs as $key => $thumb)
            {
                $magicianObj = new ImageLib($file->path);
                $magicianObj->resizeImage($thumb['width'], $thumb['height'], $thumb['crop'], true);
                if (isset($thumb['watermark']) == true) {
                    $magicianObj->addWatermark('http://'.$_SERVER['SERVER_NAME'].$thumb['watermark'], $thumb['position'], $thumb['padding'], $thumb['opacity']);
                }
                $magicianObj->saveImage($dir.'/'.$key.'.'.$thumb['format'], $thumb['quality']);
                $result[] = $key.'.'.$thumb['format'];
            }
        }

        return $result;*/

        $this->checkDir($dir);
        $result = array();
        $i = 1;
        foreach ($filesInfo as $file)
        {
            foreach ($thumbs as $key => $thumb)
            {
                // http://phpimageworkshop.com/documentation.html
                $layer = ImageWorkshop::initFromPath($file->path);
                switch ($thumb['action']) {
                    case "exact_resize":
                        $layer->resizeInPixel($thumb['width'], $thumb['height'], true, 0, 0, 'MM');
                        break;
                    case "landscape_resize":
                        $layer->resizeInPixel($thumb['width'], null, true);
                        break;
                    case "portrait_resize":
                        $layer->resizeInPixel(null, $thumb['height'], true);
                        break;
                    case "exact_crop":
                        if ($thumb['width']/$thumb['height'] < 1) {
                            $resize = $thumb['width'];
                        } else {
                            $resize = $thumb['height'];
                        }
                        $layer->resizeByNarrowSideInPixel($resize, true);
                        $layer->cropInPixel($thumb['width'], $thumb['height'], 0, 0, "MM");
                        break;
                    default:
                        $layer->resizeInPixel($thumb['width'], $thumb['height'], false); //exact, without props
                        break;
                }

                if (isset($thumb['watermark']) == true) {
                    $watermarkLayer = ImageWorkshop::initFromPath(__DIR__.'/../Resources/public/images/'.$thumb['watermark']);
                    $watermarkLayer->opacity($thumb['opacity']);
                    $layer->addLayerOnTop($watermarkLayer, $thumb['padding'], $thumb['padding'], $thumb['position']);
                }
                $this->checkDir($dir.'/'.$i);
                $name = $key.uniqid().'.'.$thumb['format'];
                $layer->save($dir.'/'.$i, $name, false, null, $thumb['quality']);

                $result[] = $i.'/'.$name;
            }
            $i++;
            unlink($file->path);
        }
        return $result;

    }

    private function checkDir($dir)
    {
        if (!is_dir($dir))
            mkdir($dir, 0777, true);
        chmod($dir, 0777);

    }

    private function clearSessionAttr()
    {
        $this->session->remove($this->sessionAttr);
    }

}