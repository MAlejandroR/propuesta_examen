<?php


class Directorio
{
    private $contenido_dir = [];


    /**
     * Elimina el dir . y .. de la lista de directorios que
     * se recibe como argumento
     *
     */
    public function quita_puntos(&$contenido)
    {
        $pos_punto = array_search(".", $contenido);
        unset ($contenido[$pos_punto]);
        $pos_punto_punto = array_search("..", $contenido);
        unset ($contenido[$pos_punto_punto]);
    }

    /**
     * Directorio constructor.
     * @param string $dir directorio del que vamos a obtener su contenido
     */
    public function __construct($dir = "idiomas")
    {
        $this->ruta = $dir;
        $this->contenido_dir = scandir($dir);
        $this->quita_puntos($this->contenido_dir);

    }


    //El contendio del directorio actual
    public function get_contenido_dir()
    {
        return $this->contenido_dir;
    }

    /**
     * @return bool si el directorio actual está o no vacío
     */
    public function vacio()
    {
        if (count($this->contenido_dir) == 0)
            return true;
        else
            return false;
    }


    /**
     * actualiza el atributo contenido_dir
     * Importante hacerlo después de cualquier modificación (crear o borrar elementos)
     */
    private function actualiza_contenido()
    {
        $this->contenido_dir = scandir($this->ruta);
        $this->quita_puntos($this->contenido_dir);

    }

    /**
     * @param $directorio a crear
     * @return bool si lo ha creado o no
     * Apache tiene que tener permisos de escritura y ejecutción
     * en el direcorio dónde se quiere crear $this->ruta
     */
    public function add_dir($directorio)
    {
        $created = false;
        if (@mkdir("$this->ruta/$directorio", 0777)) {
            $this->actualiza_contenido();
            $created = true;
        }
        return $created;
    }

    /**
     * @param $directorio direcotorio a borrar Debe existir, estar vacío y con permisos para apache
     * @return bool si lo ha borrado o no
     */
    public function del_dir($directorio)
    {
        var_dump($directorio);
        $deleted = false;
        //Cuidado, el dir tiene que estar vacío
        if (rmdir("$this->ruta/$directorio")) {
            $this->actualiza_contenido();
            $deleted = true;
        }
        return $deleted;
    }

    /**
     * @param $ruta
     * @param $directorio
     * @return array|bool|false el contendio del directorio o false si no se ha podido leer
     */

    public function get_ficheros($ruta, $directorio)
    {
        //Si no se especifica ruta, pongo la de por defecto
        $ruta = is_null($ruta) ? $this->ruta : $ruta;
        $ficheros = false;
        if (is_dir("$ruta/$directorio")) {
            $ficheros = scandir("$ruta/$directorio");
            $this->quita_puntos($ficheros);
        }
        return $ficheros;
    }
}