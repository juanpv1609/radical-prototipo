<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Pais;
use App\Models\User;
use App\Models\TipoTarea;
use App\Models\Frecuencia;
use App\Models\EstadoTarea;
use App\Models\EstadoContrato;
use Illuminate\Database\Seeder;
use App\Models\TipoIdentificacion;
use Illuminate\Support\Facades\Hash;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //php artisan migrate:fresh --seed
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin'),
            'role' => 2
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('secret'),
            'role' => 1
        ]);
        // areas
        Area::create([
            'nombre' => 'Infraestructura',
            'descripcion' => 'Infraestructura',
            'estado' => 1
        ]);
        Area::create([
            'nombre' => 'Ciberseguridad',
            'descripcion' => 'seguridad de tecnología de la información',
            'estado' => 1
        ]);

        Area::create([
            'nombre' => 'SOC',
            'descripcion' => 'Centros de Operaciones de Seguridad',
            'estado' => 1
        ]);
        // estado contratos
        EstadoContrato::create([
            'descripcion' => 'Iniciado',
            'color' => 'info'
        ]);
        EstadoContrato::create([
            'descripcion' => 'Terminado',
            'color' => 'success'
        ]);
        EstadoContrato::create([
            'descripcion' => 'Aulado',
            'color' => 'danger'
        ]);
        //estado tareas
        EstadoTarea::create([
            'descripcion' => 'Pendiente',
            'color' => 'warning'
        ]);
        EstadoTarea::create([
            'descripcion' => 'Terminado',
            'color' => 'success'
        ]);
        EstadoTarea::create([
            'descripcion' => 'Aulado',
            'color' => 'danger'
        ]);
        EstadoTarea::create([
            'descripcion' => 'Aplazado',
            'color' => 'info'
        ]);
        //frecuencias
        Frecuencia::create([
            'descripcion' => 'DIARIA',
            'alerta' => 1,
            'estado' => 0
        ]);
        Frecuencia::create([
            'descripcion' => 'SEMANAL',
            'alerta' => 2,

            'estado' => 1
        ]);
        Frecuencia::create([
            'descripcion' => 'MENSUAL',
            'alerta' => 10,

            'estado' => 1
        ]);
        Frecuencia::create([
            'descripcion' => 'TRIMESTRAL',
            'alerta' => 15,

            'estado' => 1
        ]);
        Frecuencia::create([
            'descripcion' => 'SEMESTRAL',
            'alerta' => 20,

            'estado' => 1
        ]);
        Frecuencia::create([
            'descripcion' => 'ANUAL',
            'alerta' => 30,

            'estado' => 1
        ]);
        //PAISES
        Pais::create([
            'nombre' => 'Ecuador',
            'abreviatura' => 'EC',
            'estado' => 1
        ]);
        //tipo identificacion
        TipoIdentificacion::create([
            'nombre' => 'RUC',
            'estado' => 1
        ]);
        TipoIdentificacion::create([
            'nombre' => 'CEDULA',
            'estado' => 1
        ]);
        TipoIdentificacion::create([
            'nombre' => 'PASAPORTE',
            'estado' => 1
        ]);
        // tipo tarea
        TipoTarea::create([
            'nombre' => 'INFORME',
            'descripcion' => ''
        ]);
        TipoTarea::create([
            'nombre' => 'FIREWALL',
            'descripcion' => ''
        ]);
        TipoTarea::create([
            'nombre' => 'IPS',
            'descripcion' => ''
        ]);







    }
}
