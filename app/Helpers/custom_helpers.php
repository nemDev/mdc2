<?php


use App\Models\Permission;

if (!function_exists('convertPermissionsToString')) {
    /**
     * Convert permissions from array to string comma separated.
     *
     * @param array $permissions
     * @return string
     */
    function convertPermissionsToString(array $permissions)
    {
        $string = '';
        $string = implode(', ', $permissions);

        return  $string;
    }
}

if (!function_exists('convertPermissionsToArray')) {
    /**
     * Convert permissions from comma separated string to array
     * @return string
     * @param array $permissions
     */
    function convertPermissionsToArray(string $permissions, string $returnColumn = 'id'):array
    {
        $permissions = explode(',', $permissions);
        foreach ($permissions as &$permission){
            $permission = trim($permission);
        }

        if($returnColumn == 'id'){
            $permissions = Permission::whereIn('name', $permissions)->pluck('id')->toArray();
        }

        if($returnColumn == 'name'){
            $permissions = Permission::whereIn('name', $permissions)->pluck('name')->toArray();
        }

        return $permissions;
    }
}

if (!function_exists('getAllowedImportTypes')) {
    /**
     * Convert permissions from comma separated string to array
     * @return array
     * @param array $permissions
     * @param array $importTypes
     */
    function getAllowedImportTypes(array $permissions, array $importTypes):array
    {
        foreach ($importTypes as $key => $type) {
            if(!in_array($type['permission_required'], $permissions)) {
                unset($importTypes[$key]);
            }
        }
        return $importTypes;
    }
}

if(!function_exists('juicer')) {

    function juicer(){


        interface Juiceable
        {
            public function squeeze(): float;
        }

        class Fruit implements Juiceable
        {
            protected string $color;
            protected float $volume;

            public function __construct(string $color, float $volume)
            {
                $this->color = $color;
                $this->volume = $volume;
            }

            public function getVolume(): float
            {
                return $this->volume;
            }

            public function squeeze(): float
            {
                return $this->volume * 0.5; // 50% of the fruit's volume
            }
        }

        class Apple extends Fruit
        {
            private bool $isRotten;

            public function __construct(string $color, float $volume, bool $isRotten)
            {
                parent::__construct($color, $volume);
                $this->isRotten = $isRotten;
            }

            public function isRotten(): bool
            {
                return $this->isRotten;
            }
        }

        class FruitContainer
        {
            private float $capacity;
            private array $fruits = [];

            public function __construct(float $capacity)
            {
                $this->capacity = $capacity;
            }

            public function addFruit(Fruit $fruit): bool
            {
                if ($this->getRemainingCapacity() >= $fruit->getVolume()) {
                    $this->fruits[] = $fruit;
                    return true;
                }
                return false;
            }

            public function getFruitCount(): int
            {
                return count($this->fruits);
            }

            public function getRemainingCapacity(): float
            {
                $usedCapacity = array_reduce($this->fruits, fn($carry, $fruit) => $carry + $fruit->getVolume(), 0);
                return $this->capacity - $usedCapacity;
            }

            public function getFruits(): array
            {
                return $this->fruits;
            }
        }

        class Strainer
        {
            public function squeezeFruits(FruitContainer $container): float
            {
                $juice = 0;
                foreach ($container->getFruits() as $fruit) {
                    if ($fruit instanceof Apple && $fruit->isRotten()) {
                        continue; // Skip rotten apples
                    }
                    $juice += $fruit->squeeze();
                }
                return $juice;
            }
        }

        class Juicer
        {
            private FruitContainer $container;
            private Strainer $strainer;
            private float $totalJuice = 0;

            public function __construct(float $capacity)
            {
                $this->container = new FruitContainer($capacity);
                $this->strainer = new Strainer();
            }

            public function performAction(int $actionNumber): void
            {
                if ($actionNumber % 9 === 0) {
                    $volume = rand(1, 5);
                    $isRotten = rand(0, 100) < 20; // 20% chance of being rotten
                    $apple = new Apple("red", $volume, $isRotten);
                    if ($this->container->addFruit($apple)) {
                        echo '<pre>';
                        echo "Action $actionNumber: Added an apple (Volume: $volume, Rotten: " . ($isRotten ? "Yes" : "No") . ")\n";
                        echo '</pre>';
                    } else {
                        echo '<pre>';
                        echo "Action $actionNumber: Not enough space to add an apple.\n";
                        echo '</pre>';
                    }
                } else {
                    $juice = $this->strainer->squeezeFruits($this->container);
                    $this->totalJuice += $juice;
                    echo '<pre>';
                    echo "Action $actionNumber: Squeezed juice - $juice liters (Total: $this->totalJuice liters)\n";
                    echo '</pre>';
                }
            }

            public function simulate(int $actions): void
            {
                for ($i = 1; $i <= $actions; $i++) {
                    $this->performAction($i);
                }
            }
        }

        // Simulation
        $juicer = new Juicer(20);
        $juicer->simulate(100);
    }
}
