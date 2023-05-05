<?php
//By by2 文件去重用
namespace OSS\Result;

use OSS\Core\OssUtil;
use OSS\Model\FileInfo;

class MetaQueryResult extends Result
{
    protected function parseDataFromResponse()
    {
        $res = array();

        $xml = new \SimpleXMLElement($this->rawResponse->body);
        $encodingType = isset($xml->EncodingType) ? strval($xml->EncodingType) : "";
        if(isset($xml->Files) && isset($xml->Files->File)){
            foreach ($xml->Files->File as $file) {
                $filename = isset($file->Filename) ? strval($file->Filename) : "";
                $res['filename'] = OssUtil::decodeKey($filename, $encodingType);
                $res['size'] = isset($file->Size) ? strval($file->Size) : "0";
                $res['fileModifiedTime'] = isset($file->FileModifiedTime) ? strval($file->FileModifiedTime) : "";
                $res['eTag'] = isset($file->ETag) ? strval($file->ETag) : "";
                break;
            }
        }
        return $res;
    }
}