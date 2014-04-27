<?php
class Core_Image
{
	public function resize($src, $dest, $size, $quality = 90)
	{
		if ( $param = getimagesize($src) ) {
			
			if ( $param[2] == 1 ) $isrc = imagecreatefromgif ($src);
			if ( $param[2] == 2 ) $isrc = imagecreatefromjpeg ($src);
			if ( $param[2] == 3 ) $isrc = imagecreatefrompng ($src);
			
			if ( $param[0] > $param[1] ) {
				
				$koef=$param[1]/$size;
				$idest = imagecreatetruecolor($param[0]/$koef, $size);
				imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $param[0]/$koef, $size, $param[0], $param[1]);
				imagejpeg($idest, $dest, $quality);
				
			}
			else {
				
				$koef=$param[0]/$size;
				$idest = imagecreatetruecolor($size, $param[1]/$koef);
				imagecopyresampled($idest, $isrc, 0, 0, 0, 0, $size, $param[1]/$koef, $param[0], $param[1]);
				imagejpeg($idest, $dest, $quality);
				
			}
		}
		else throw new Core_Image_Exception('File is not image');
	}
}