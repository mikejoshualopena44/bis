<?php

class Image
{  
	public function generate_filename($length)
	{

		$array = array(0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		$text = "";

		for($x = 0; $x < $length; $x++)
		{

			$random = rand(0,61);
			$text .= $array[$random];
		}

		return $text;
	}


    //To resize the image base on specified value to avoid maot na imge
    public function crop_img($original_file_name,$cropped_file_name,$max_width,$max_height)
    {
        if(file_exists($original_file_name))
        {
            $original_img = imagecreatefromjpeg($original_file_name);

            $original_width = imagesx( $original_img);
            $original_height = imagesy( $original_img);

            if($original_height > $original_width)
            {
                //if image is more on height crop height
                $ratio = $max_width / $original_width;

                $new_width = $max_width;
                $new_height = $original_height * $ratio;

            }else
            {
                //if image is more on width crop width
                $ratio = $max_height / $original_height;

                $new_height = $max_height;
                $new_width = $original_width * $ratio;

            }

        }
        //adjust incase max width and height are different
        if($max_width != $max_height)
        {
            if($max_height > $max_width )
            {
                if($max_height > $new_height )
                {
                    $adjustment = ($max_height / $new_height);
                }else
                {
                    $adjustment = ($new_height / $max_height);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }else
            {
                if($max_width > $new_width )
                {
                    $adjustment = ($max_width / $new_width);
                }else
                {
                    $adjustment = ($new_width / $max_width);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
        }


        //Only resize not cropted
        //crop height or crop width of the image


        $new_img = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_img, $original_img,0,0,0,0, $new_width, $new_height, $original_width, $original_height);

        imagedestroy($original_img);

        if($max_width != $max_height)
        {
            if($max_width > $max_height)
            {
                $diff = ($new_height - $max_height);
                if($diff < 0){
                   $diff = $diff *-1; 
                }
                
                $y = round($diff/2);
                $x = 0;
            }else
            {
                $diff = ($new_width - $max_height);
                if($diff < 0){
                    $diff = $diff *-1; 
                 }
                 
                $diff = ($new_width - $new_height);
                $x = round($diff/2);
                $y = 0;
            }    

        }else
        {

            if($new_height > $new_width)
            {
                $diff = ($new_height - $new_width);
                $y = round($diff/2);
                $x = 0;
            }else
            {
                $diff = ($new_width - $new_height);
                $x = round($diff/2);
                $y = 0;
            }
        }

        $new_cropped_image = imagecreatetruecolor($max_width, $max_height);
        imagecopyresampled($new_cropped_image, $new_img, 0, 0, $x, $y, $max_width, $max_height,$max_width, $max_height);
        imagedestroy($new_img);

        imagejpeg($new_cropped_image, $cropped_file_name, 90);
        imagedestroy($new_cropped_image);
    }

    //resize the image
    public function resize_img($original_file_name,$resized_file_name,$max_width,$max_height)
    {
        if(file_exists($original_file_name))
        {
            $original_img = imagecreatefromstring(file_get_contents($original_file_name));

            $original_width = imagesx( $original_img);
            $original_height = imagesy( $original_img);

            if($original_height > $original_width)
            {
                //if image is more on height crop height
                $ratio = $max_width / $original_width;

                $new_width = $max_width;
                $new_height = $original_height * $ratio;

            }else
            {
                //if image is more on width crop width
                $ratio = $max_height / $original_height;

                $new_height = $max_height;
                $new_width = $original_width * $ratio;

            }

        }
        //adjust incase max width and height are different
        if($max_width != $max_height)
        {
            if($max_height > $max_width )
            {
                if($max_height > $new_height )
                {
                    $adjustment = ($max_height / $new_height);
                }else
                {
                    $adjustment = ($new_height / $max_height);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }else
            {
                if($max_width > $new_width )
                {
                    $adjustment = ($max_width / $new_width);
                }else
                {
                    $adjustment = ($new_width / $max_width);
                }
                $new_width = $new_width * $adjustment;
                $new_height = $new_height * $adjustment;
            }
        }


        //Only resize not cropted
        //crop height or crop width of the image


        $new_img = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($new_img, $original_img,0,0,0,0, $new_width, $new_height, $original_width, $original_height);

        imagedestroy($original_img);

        imagejpeg($new_img, $resized_file_name, 90);
        imagedestroy($new_img);
        
    }
    //Create thumbnail for ccover photo
    public function get_thumb_cover($filename)
    {
        $thumbnail = $filename . "_cover_thumb.jpg";
        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }


        $this->crop_img($filename, $thumbnail, 1366,488);

        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }else
        {
            return $filename;
        }
    }

    //Create thumbnail for Profile photo
    public function get_thumb_profile($filename)
    {
        $thumbnail = $filename . "_profile_thumb.jpg";
        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }


        $this->crop_img($filename, $thumbnail, 600,600);

        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }else
        {
            return $filename;
        }
    }

    //Create thumbnail for posts photo
    public function get_thumb_posts($filename)
    {
        $thumbnail = $filename . "_posts_thumb.jpg";
        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }
    
    
        $this->crop_img($filename, $thumbnail, 900,600);

        if(file_exists($thumbnail))
        {
            return $thumbnail;
        }else
        {
            return $filename;
        }
    }


    public function isProfileOrCoverImage($postID)
    {
        $DB = new CONNECTION_DB();
        $query = "SELECT is_profile_image, is_cover_image FROM posts WHERE post_id = '$postID'";
        $result = $DB->read($query);

        if ($result && count($result) > 0) {
            $imageData = $result[0];
            return ($imageData['is_profile_image'] == 1 || $imageData['is_cover_image'] == 1);
        }

        return false;
    }

    
}



































/*
class BackgroundImg
{
    public function crop_img($original_file_name, $cropped_file_name, $max_width, $max_height)
    {
        if (file_exists($original_file_name)) {
            $original_img = imagecreatefromjpeg($original_file_name);

            $original_width = imagesx($original_img);
            $original_height = imagesy($original_img);

            $new_width = $max_width;
            $new_height = $max_height;

            $x = 0; // Start X position
            $y = 0; // Start Y position

            // Calculate the aspect ratio of the original image
            $original_aspect = $original_width / $original_height;
            $new_aspect = $new_width / $new_height;

            if ($original_aspect > $new_aspect) {
                // Original image is wider, crop height
                $source_width = $original_width;
                $source_height = $original_width / $new_aspect;
                $y = ($original_height - $source_height) / 2;
            } else if ($original_aspect < $new_aspect) {
                // Original image is taller, crop width
                $source_width = $original_height * $new_aspect;
                $source_height = $original_height;
                $x = ($original_width - $source_width) / 2;
            } else {
                // Aspect ratios are the same, no need to crop
                $source_width = $original_width;
                $source_height = $original_height;
            }

            $new_img = imagecreatetruecolor($new_width, $new_height);

            imagecopyresampled($new_img, $original_img, 0, 0, $x, $y, $new_width, $new_height, $source_width, $source_height);

            imagedestroy($original_img);

            imagejpeg($new_img, $cropped_file_name, 100);
        }
    }
}

*/
?>