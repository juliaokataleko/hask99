<?php
class File {

	private $supported_formats = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

	public function upload($file, $uniq){
		if(is_array($file)){
			if(in_array($file['type'], $this->supported_formats)) {
				move_uploaded_file($file['tmp_name'], 'uploads/' . $uniq . $file['name']);
				echo "Ficheiro enviado";
			}else {
				echo "Ficheiro não suportado";
			}
		}
	}

}
