<?php
namespace App\Entity;


class BirdModel{

    private $birds = [
        [
            'name' => 'White bird',
            'description' => 'The chubby white bird drops an egg bomb when players tap the screen after launching the creature from the slingshot.',
            'image' => 'white.png',
        ],
        [
            'name' => 'Black bird',
            'description' => 'Black birds act as bombs, which explode once they\'ve landed on a target, obliterating pigs and buildings around them.',
            'image' => 'black.png',
        ],
        [
            'name' => 'Red bird',
            'description' => 'The first avian missile players encounter when they start the game, the red bird follows a simple trajectory when launched.',
            'image' => 'red.png',
        ],
        [
            'name' => 'Blue bird',
            'description' => 'The blue bird splits into three smaller versions in mid-air when the screen is tapped.',
            'image' => 'blue.png',
        ],
        [
            'name' => 'Yellow bird',
            'description' => 'Tapping the screen after launching the yellow bird gives the critter a speed boost that makes it more deadly.',
            'image' => 'yellow.png',
        ],
        [
            'name' => 'Green bird',
            'description' => 'The green bird turns into a boomerang that doubles back to strike targets in otherwise protected locations.',
            'image' => 'green.png',
        ],
        [
            'name' => 'Big red bird',
            'description' => 'The big red bird is a flying wrecking bail that causes more damage than his smaller red cousin.',
            'image' => 'red-big.png',
        ],

    ];
    
    /**
     * getAll
     *
     * @return void
     */
    public function getAll(){
        return $this->birds;

    }
    
   /**
     * récupère un oiseau par son identifiant
     *
     * @param int $id
     * @return array
     */
    public function get($id){
         // pour vérifier si une clé dans un tableau on peut utiliser 
        // isset($this->birds[$id])
        // ou array_key_exists
        if (! array_key_exists($id, $this->birds)) 
        {
            
            return null;
        }
        return $this->birds[$id];
    }
    
     /**
     * récupère un oiseau par son nom
     *
     * @param string $birdName
     * @return array
     */
    public function getByName($birdName) {
        foreach ($this->birds as $currentBird) {
            if ($birdName == $currentBird['name']) {
                return $currentBird;
            }
        }
        return null;
    }
}