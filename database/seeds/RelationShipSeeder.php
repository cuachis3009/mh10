<?php

use App\RelationShip;
use Illuminate\Database\Seeder;

class RelationShipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $relationships = array('Madre','Padre','Hijo(a)','Hermano(a)','Tio(a)','Primo(a)','Sobrino(a)','Abuelo(a)','Cuñado(a)','Nieto(a)','Familiar lejano','Suegro(a)','Nuera','Yerno','Consuegro','Concuñado','Padrino','Madrina','Vecino(a)','Conocido(a)','Amigo(a)','Esposa','Esposo');

        foreach ($relationships as $rl) {
            $relation = new RelationShip;
            $relation->name = $rl;
            $relation->save();
        }
    }
}
