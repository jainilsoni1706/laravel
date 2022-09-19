<?php

namespace App\Classes;

use Illuminate\Support\Str;
use DB;
use Mail;
use File;
use Storage;


class Helper
{
     //for insertion data
     public function InsertData($tableName,$insertionData)
     {
         if(DB::table($tableName)->insert([$insertionData]))
         {
             return 1;
         }
         else
         {
             return 0;
         }
     }    
 
     //to update data
     public function UpdationData($tableName,$conditionParam,$conditionValue,$updateData)
     {
         if(DB::table($tableName)->where($conditionParam,$conditionValue)->update($updateData))
         {
             return 1;
         }
         else
         {
             return 0;
         }
     }
 
     //to delete data
     public function DeleteData($tableName,$conditionParam,$conditionValue)
     {
         if(DB::table($tableName)->where($conditionParam,$conditionValue)->delete())
         {
             return 1;
         }
         else
         {
             return 0;
         }
     }
 
     //file Checker
     public function fileFormatChecker($file)
     {
         if($request->file($file)->extension() == "jpg" || $request->file($file)->extension() == "jpeg" || $request->file($file)->extension() == "png" || $request->file($file)->extension() == "webp" || $request->file($file)->extension() == "gif")
         {
             return "image";
         }
         elseif($request->file($file)->extension() == "mp4" || $request->file($file)->extension() == "mov" || $request->file($file)->extension() == "wmv" || $request->file($file)->extension() == "avi" || $request->file($file)->extension() == "avchd" || $request->file($file)->extension() == "flv" || $request->file($file)->extension() == "mkv")
         {
             return "video";
         }
         elseif($request->file($file)->extension() == "pdf")
         {
             return "pdf";
         }
         elseif($request->file($file)->extension() == "html" || $request->file($file)->extension() == "txt" || $request->file($file)->extension() == "js" || $request->file($file)->extension() == "css" || $request->file($file)->extension() == "py" || $request->file($file)->extension() == "php" || $request->file($file)->extension() == "phtml" || $request->file($file)->extension() == "c" || $request->file($file)->extension() == "cs" || $request->file($file)->extension() == "cpp" || $request->file($file)->extension() == "ppt" || $request->file($file)->extension() == "doc" || $request->file($file)->extension() == "docx" || $request->file($file)->extension() == "xlsx" || $request->file($file)->extension() == "xlsm" || $request->file($file)->extension() == "blade" || $request->file($file)->extension() == "java" || $request->file($file)->extension() == "xml" || $request->file($file)->extension() == "json")
         {
             return "document";
         }
         else
         {
             return "Unknown Format";
         }
     }
 
     //user is exist or not checker
     public function isUserExist($tableName,$userParam,$userValue)
     {
         if(DB::table($tableName)->where($userParam,$userValue)->count() == 1)
         {
             return 1;
         }
         else
         {
             return 0;
         }
     }
 
     //single file remover
     public function deleteSingleFile($filePath,$fileName)
     {
         if(File::exists($filePath.$fileName))
         {
             unlink($filePath.$fileName);
 
             return 1;
         }
         else
         {
             return 0;
         }
     }
 
     //multiple file delete
     public function deleteMultipleFile($filePath,$fileName)
     {
         foreach($fileName as $fileName)
         {
             if(File::exists($filePath.$fileName))
             {
                 unlink($filePath.$fileName);
 
                 return 1;
             }
             else
             {
                 return 0;
             }
         }
     }
 
     public function sendMail($to,$subject,$template)
     {
 
         $token = Str::random(30);
 
         $data = ['token' => $token, 'frommail' => env('MAIL_FROM_ADDRESS'), 'tomail' => $to, 'subject' => $subject];
 
         Mail::send($template, $data, function ($message) use ($data)
         {
             $message->to($data['tomail']);
             $message->from($data['frommail']);
             $message->subject($data['subject']);
         });
     }
 
     public function sendMailWithAttachment($to,$subject,$template,$files = array())
     {
         $token = Str::random(30);
 
         $data = ['token' => $token, 'frommail' => env('MAIL_FROM_ADDRESS'), 'tomail' => $to, 'subject' => $subject];
 
         Mail::send($template, $data, function ($message) use ($data,$files)
         {
             $message->to($data['tomail']);
             $message->from($data['frommail']);
             $message->subject($data['subject']);
             $message->attach($files);
 
         });
     }

    public function getExtension($parameter)
    {
        return $parameter->extension();
    }

    public function isFileImage($parameter)
    {
        if($parameter == "png" || $parameter == "jpg" || $parameter == "jpeg" || $parameter == "avif")
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function isFilePDF($parameter)
    {
        if($parameter == "pdf")
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }



    public function isFileVideo($parameter)
    {
        if($parameter == "mkv" || $parameter == "mp4" || $parameter == "wmv" || $parameter == "avi" || $parameter == "mov" || $parameter == "flv" || $parameter == "bin")
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function saveProfile($parameter)
    {
        $name = rand(11111111,99999999).time().".".$parameter->extension();
        $parameter->move(public_path('assets/profile'),$name);

        return $name;
    }

     public function savePost($parameter)
    {
        $name = rand(11111111,99999999).time().".".$parameter->extension();
        $parameter->move(public_path('assets/posts'),$name);

        return $name;
    }

    public function saveIcon($parameter)
    {
        $name = rand(11111111,99999999).time().".".$parameter->extension();
        $parameter->move(public_path('assets/icon'),$name);

        return $name;
    }

    public function saveThumbnail($parameter)
    {
        $name = rand(11111111,99999999).time().".".$parameter->extension();
        $parameter->move(public_path('assets/video_thumbnail'),$name);

        return $name;
    }

    public function saveFile($parameter)
    {
        $name = rand(11111111,99999999).time().".".$parameter->extension();
        $parameter->move(public_path('assets'),$name);

        return $name;
    }

    public function saveVideo($parameter)
    {
        if($parameter->extension() == "bin")
        {
            $name = rand(11111111,99999999).time().".mp4";
        }

        $name = rand(11111111,99999999).time().".mp4";
        $parameter->move(public_path('assets/videos'),$name);

        return $name;
    }
}
