<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tipo;
use App\Models\Vacacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@flypacks.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'rol' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        
        $user = User::firstOrCreate(
            ['email' => 'user@flypacks.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'rol' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // 2. Create Types
        $tipos = ['Playa', 'Montaña', 'Ciudad', 'Aventura', 'Crucero', 'Rural'];
        $tipoIds = [];
        foreach ($tipos as $nombre) {
            $tipo = Tipo::firstOrCreate(['nombre' => $nombre]);
            $tipoIds[] = $tipo->id;
        }

        // 3. Create Vacations
        // Helper to pick random
        $countries = ['España', 'Francia', 'Italia', 'Japón', 'EEUU', 'México', 'Tailandia', 'Grecia', 'Australia', 'Brasil'];
        $adjectives = ['Increíble', 'Relajante', 'Inolvidable', 'Salvaje', 'Romántica', 'Exclusiva', 'Económica'];
        
        for ($i = 0; $i < 30; $i++) {
             $tipoId = $tipoIds[array_rand($tipoIds)];
             $country = $countries[array_rand($countries)];
             $adj = $adjectives[array_rand($adjectives)];
             $title = "Escapada $adj a $country";
             
             Vacacion::create([
                 'titulo' => $title,
                 'descripcion' => "Disfruta de una experiencia única en $country. Incluye vuelos, alojamiento y visitas guiadas. ¡Reserva ahora y vive la aventura de tu vida!",
                 'precio_pp' => rand(300, 3000) + (rand(0, 99) / 100),
                 'tipo_id' => $tipoId,
                 'pais' => $country,
                 'fotos' => null, // Opcional: podrías poner rutas fijas si tuvieras imagenes de prueba
             ]);
        }
    }
}
