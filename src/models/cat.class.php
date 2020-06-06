<?php
class Cat {

    public $id = null;
    public $img;
    public $name;
    public $age;
    public $catInfo;
    public $wins;
    public $loss;

    private function __construct($id, $img, $name, $age, $catInfo, $wins, $loss) {
        $this->id = $id;
        $this->img = $img;
        $this->name = $name;
        $this->age = $age;
        $this->catInfo = $catInfo;
        $this->wins = $wins;
        $this->loss = $loss;
    }

    public static function createCat($img, $name, $age, $catInfo, $wins, $loss) {
        return new Cat(null, $img, $name, $age, $catInfo, $wins, $loss);
    }

    public static function createCatWithId($id, $img, $name, $age, $catInfo, $wins, $loss) {
        return new Cat($id, $img, $name, $age, $catInfo, $wins, $loss);
    }

}?>