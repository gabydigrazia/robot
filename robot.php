<?php
    $initial_pos = '0 0';
    $min_obstacles_qty = 1;
    $max_obstacles_qty = 10;
    $min_commands_qty = 1;
    $max_commands_qty = 10000; 
    $min_steps_qty = 1;
    $max_steps_qty = 10;
    $xynegative_limit_obstacle = -100000; // Limit of negative obstacle coordinates
    $xypositive_limit_obstacle = 100000; // Limit of positive obstacle coordinates
    $direction = 'N'; // Direction where robot walks. Starts walking North
    $max_distance = 0;

    // Gets number of obstacles and commands
    function getObstaclesCommandsQty($min_obstacles_qty, $max_obstacles_qty, $min_commands_qty, $max_commands_qty) {
        $oc = readline('Ingrese número de obstáculos y de comandos: ');
        echo PHP_EOL;
        $obstacles_qty = intval(strstr($oc, ' ', true));
        $commands_qty = intval(ltrim(strstr($oc, ' ')));   

        if ($obstacles_qty < $min_obstacles_qty || $obstacles_qty > $max_obstacles_qty || $commands_qty < $min_commands_qty || $commands_qty > $max_commands_qty) {
            echo 'Número de obstáculos permitidos entre ' . $min_obstacles_qty . ' y ' . $max_obstacles_qty .
                '. Número de comandos permitidos entre ' . $min_commands_qty . ' y ' . $max_commands_qty . ' comandos.' .PHP_EOL;
            echo PHP_EOL;
            return getObstaclesCommandsQty($min_obstacles_qty, $max_obstacles_qty, $min_commands_qty, $max_commands_qty);
        } 

        return $oc;
    }

    // Calculates new position when robot moves
    function move($start_pos, $steps_qty, $direction, $obstacles) {
        switch ($direction) {
            case 'N':
                // Calculetes new position if direction is North
                $x = ltrim(strstr($start_pos, ' ', true));
                $y1 = ltrim(strstr($start_pos, ' '));
                $y2 = $y1 + $steps_qty;

                $new_pos = $x . ' ' . $y2;

                foreach ($obstacles as $obstacle) {
                    $x_obstacle = ltrim(strstr($obstacle, ' ', true));
                    $y_obstacle = ltrim(strstr($obstacle, ' '));
                    if ($x === $x_obstacle && $y2 >= $y_obstacle) {
                        $new_y = $y_obstacle - 1;
                        $new_pos = $x . ' ' . $new_y;
                    }
                }

                return $new_pos;
                break;

            case 'S':

                // Calculetes new position if direction is South
                $x = ltrim(strstr($start_pos, ' ', true));
                $y1 = ltrim(strstr($start_pos, ' '));
                $y2 = $y1 - $steps_qty;

                $new_pos = $x . ' ' . $y2;

                foreach ($obstacles as $obstacle) {
                    $x_obstacle = ltrim(strstr($obstacle, ' ', true));
                    $y_obstacle = ltrim(strstr($obstacle, ' '));
                    if ($x === $x_obstacle && $y2 <= $y_obstacle) {
                        $new_y = $y_obstacle + 1;
                        $new_pos = $x . ' ' . $new_y;
                    }
                }
                
                return $new_pos;
                break;

            case 'E':
                // Calculetes new position if direction is East
                $x1 = ltrim(strstr($start_pos, ' ', true));
                $x2 = $x1 + $steps_qty;
                $y = ltrim(strstr($start_pos, ' '));

                $new_pos = $x2 . ' ' . $y;

                foreach ($obstacles as $obstacle) {
                    $x_obstacle = ltrim(strstr($obstacle, ' ', true));
                    $y_obstacle = ltrim(strstr($obstacle, ' '));
                    if ($y === $y_obstacle && $x2 >= $x_obstacle) {
                        $new_x = $x_obstacle - 1;
                        $new_pos = $new_x . ' ' . $y;
                    }
                }

                return $new_pos;
                break;

            case 'O':
                // Calculetes new position if direction is West
                $x1 = ltrim(strstr($start_pos, ' ', true));
                $x2 = $x1 - $steps_qty;
                $y = ltrim(strstr($start_pos, ' '));

                $new_pos = $x2 . ' ' . $y;

                foreach ($obstacles as $obstacle) {
                    $x_obstacle = ltrim(strstr($obstacle, ' ', true));
                    $y_obstacle = ltrim(strstr($obstacle, ' '));
                    if ($y === $y_obstacle && $x2 <= $x_obstacle) {
                        $new_x = $x_obstacle + 1;
                        $new_pos = $new_x . ' ' . $y;
                    }

                }

                return $new_pos;
                break;
        }
    }

    // Gets new direction when robot turns left 90 degrees
    function turnLeft($direction) {
        switch ($direction) {
            case 'N':
                return 'O';
                break;

            case 'S':
                return 'E';
                break;
            
            case 'E':
                return 'N';
                break;

            case 'O':
                return 'S';
                break;
        }
    }

    // Gets new direction when robot turns right 90 degrees
    function turnRight($direction) {
        switch ($direction) {
            case 'N':
                return 'E';
                break;

            case 'S':
                return 'O';
                break;
            
            case 'E':
                return 'S';
                break;

            case 'O':
                return 'N';
                break;
        }
    }

    // Executes all entered commands and gets maximum distance walked by robot
    function walkAround($position, $direction, $max_distance, $obstacles, $commands) {
        foreach ($commands as $command) {
            if (strtoupper(substr($command, 0, 1)) === 'M') {
                $steps_qty = intval(ltrim(strstr($command, ' ')));
                $command = strtoupper(substr($command, 0, 1));
            }
            switch(strtoupper($command)) {
                case 'M':
                    $position = move($position, $steps_qty, $direction, $obstacles);
                    $max_distance = calculateDistance($position, $max_distance);
                    break;

                case 'L':
                    $direction = turnLeft($direction);
                    break;
                
                case 'R':
                    $direction = turnRight($direction);
                    break;
            }
        }

        return $max_distance;
    }

    // Calculates maximum distance walked by robot
    function calculateDistance($position, $max_distance) {
        $x = ltrim(strstr($position, ' ', true));
        $y = ltrim(strstr($position, ' '));
        $new_distance = sqrt(pow($x, 2) + pow($y, 2));

        if ($new_distance > $max_distance) {
            $max_distance = $new_distance;
        }

        return $max_distance;
    }

    // Gets valid command
    function getValidCommand($min_steps_qty, $max_steps_qty) {
        $command = readline('Ingrese comando: ');

        if (strtoupper(substr($command, 0, 1)) === 'M') {
            $steps_qty = intval(ltrim(strstr($command, ' ')));
            if ($steps_qty < $min_steps_qty || $steps_qty > $max_steps_qty) {
                echo 'El número de pasos permitidos debe estar entre ' . $min_steps_qty . ' y ' . $max_steps_qty;
                echo PHP_EOL;
                return getValidCommand($min_steps_qty, $max_steps_qty);
            } 
        } elseif (strtoupper(substr($command, 0, 1)) !== 'M' && strtoupper(substr($command, 0, 1)) !== 'L' && strtoupper(substr($command, 0, 1)) !== 'R') {
            echo 'Los comandos válidos que puede ingresar son: '.PHP_EOL;
            echo '  “L”: gire a la izquierda 90 grados'.PHP_EOL;
            echo '  “R”: gire a la derecha 90 grados'.PHP_EOL;
            echo '  “M n”: muévase n pasos adelante'.PHP_EOL;
            echo PHP_EOL;
            return getValidCommand($min_steps_qty, $max_steps_qty);
        }
        return $command;
    }

    // Gets valid coordinates
    function getValidCoordinates($xynegative_limit_obstacle, $xypositive_limit_obstacle) {
        $coordinate = readline('Ingrese la posición del obstaculo: ');
        echo PHP_EOL;
        $x = ltrim(strstr($coordinate, ' ', true));
        $y = ltrim(strstr($coordinate, ' '));

        if ($x < $xynegative_limit_obstacle || $x > $xypositive_limit_obstacle || $y < $xynegative_limit_obstacle || $y > $xypositive_limit_obstacle) {
            echo 'Los coordenadas válidas del obstáculo deben estar entre : ' . $xynegative_limit_obstacle . ' y ' . $xypositive_limit_obstacle .PHP_EOL;
            echo PHP_EOL;
            return getValidCoordinates($xynegative_limit_obstacle, $xypositive_limit_obstacle);
        }

        return $coordinate;
    }

    $oc_qty = getObstaclesCommandsQty($min_obstacles_qty, $max_obstacles_qty, $min_commands_qty, $max_commands_qty);
    $obstacles_qty = intval(strstr($oc_qty, ' ', true));
    $commands_qty = intval(ltrim(strstr($oc_qty, ' ')));  

    for ($i = 0; $i < $obstacles_qty; $i++) {
        $new_obstacle = getValidCoordinates($xynegative_limit_obstacle, $xypositive_limit_obstacle);
        $obstacles[$i] = $new_obstacle; 
    }

    if ($commands_qty >= $min_commands_qty) {
        for ($i = 0; $i < $commands_qty; $i++) {
            $new_command = getValidCommand($min_steps_qty, $max_steps_qty);
            $commands[$i] = $new_command;
        }
    }  
    
    $result = walkAround($initial_pos, $direction, $max_distance, $obstacles, $commands);
    echo PHP_EOL;
    echo 'Maxima distancia recorrida por el robot: ' . round($result, 2).PHP_EOL;
