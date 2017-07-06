<?php
class Validator
{
	public static function validateForm($fields)
	{
		foreach ($fields as $index => $value) {
			$value = trim($value);
			$fields[$index] = $value;
		}
		return $fields;
	}

	public static function validateImage($file, $name, $max_width, $max_heigth)
	{
     	if($file["size"] <= 2097152)
     	{
	    	list($width, $height, $type) = getimagesize($file["tmp_name"]);
			if($width <= $max_width && $height <= $max_heigth)
			{
				if($type == 1 || $type == 2 || $type == 3)
				{
					if($name == null)
					{
						$extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
						$image = time().".".$extension;
					}
					else
					{
						$image = $name;
					}
					return $image;
				}
				else
				{
					throw new Exception("El formato de la imagen debe ser gif, jpg o png");
				}
			}
			else
			{
				throw new Exception("La dimensión de la imagen no es apropiada");
			}
     	}
     	else
     	{
     		throw new Exception("El tamaño de la imagen debe ser como máximo 2MB");
     	}
	}

	public static function uploadImage($file, $path, $name)
	{
		if(file_exists($path))
		{
			if(move_uploaded_file($file, $path.$name))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public static function deleteImage($path, $name)
	{
		if(file_exists($path.$name))
		{
			if(unlink($path.$name))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public static function validateEmail($email)
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>