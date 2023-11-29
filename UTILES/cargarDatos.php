<?php

class cargarDatos
{
    private $nacionalidad;

    /**
     * cargarDatos constructor.
     * @param $nacionalidad
     */
    public function __construct($nacionalidad=array(
        'CUBA','MEXICO','USA','PANAMA','CANADA','NICARAGUA','URUGUAY','PERU','CHILE','BRASIL','HAITI','VENEZUELA',
        'ARGENTINA','COLOMBIA','ECUADOR','HONDURAS'
    ))
    {
        $this->nacionalidad = $nacionalidad;
    }


    public function generarClientes(){
        $mujeres = array(
            'Jesse Johna Gonzalez Hidalgo',
            'Liuba Maria Alfonso Torres',
            'Claudia Rodriguez Esperon',
            'Daniela Li Rodriguez',
            'Dismaray Perez Calvi',
            'Ana Hernandez Gonzalez',
            'Maura Saldivar Muñiz',
            'Laura Garcia Xenes',
            'Maria de Jesus Peñalver Quintana',
            'Juana Castañet Blanco',
        );
        $hombres = array(
            'Michel Bermudez Tamayo',
            'Luis Duran Frómeta',
            'Chris Fernandez Cepero',
            'Danny Jesus Cruz Rivero',
            'Yandry R Garcia',
            'Yoan Rodriguez Fernandez',
            'Javier Antonio Roue Sañudo',
            'Alexander Gonzalez Diaz',
            'Dairon Isidro Rodriguez del Portillo',
            'Sergio Ariel Tamayo Heredia',
            'Daynel Gonzalez Escalante',
            'Randy Castillo Columbie',
            'Jose Carlos Milanes Anaya',
            'Jasnaykel Iznaga Aguilera',
            'Eduardo Fernandez Borrego',
            'Jose Carlos Mendoza Sosa',
            'Jorge Edel Garcia',
            'Fidel Alejandro Sanchez Fernandes',
            'Orestes Guerrero Castañeda'
        );
        $nacionalidad = $this->nacionalidad;
        foreach ($hombres as $hombre){
            $cliente = new daoCliente($hombre,rand(20,50),'MASCULINO',$nacionalidad[rand(0,count($nacionalidad)-1)]);
            $cli = $cliente -> obtenerCliente();
            if(is_array($cli) && !empty($cli))
                continue;
            $cliente -> registrarCliente();
        }foreach ($mujeres as $mujer){
            $cliente = new daoCliente($mujer,rand(20,50),'FEMENINO',$nacionalidad[rand(0,count($nacionalidad)-1)]);
            $cli = $cliente -> obtenerCliente();
            if(is_array($cli) && !empty($cli))
                continue;
            $cliente -> registrarCliente();
        }
    }

    public function generarHabitaciones($cant = 100){
        $habit = new daoHabitacion();
        while ($cant > 0){
            $habit -> registrarHabitacion();
            $cant --;
        }
    }

    public function generarTurOperadores()
    {
        $nacionalidad = $this->nacionalidad;

        $nombre = array('CIMEX','VARATUR','CAMETUR','PINATUR','RIVERA','LATUR');

        foreach ($nombre as $key => $item){
            $turo = new daoTurOperador($item,$nacionalidad[rand(0,count($nacionalidad)-1)],substr($item,0,2).$key);
            $turo -> registrarElemento();
        }
    }


}