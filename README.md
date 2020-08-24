# Robot

### Situation
A robot lives at the point (0, 0) on an infinite grid. Today, he's going to walk around. His route consist in a long secuece of three possible commands: 
- Move n steps forward
- Turn left 90 degrees
- Turn right 90 degrees

The robot always starts walking North. Some grid coordinates are obstacles. If he tries to move towards them, he will stop at the previous grid coordinate (but will going on the rest of his route).

Given the list of the obstacles and the route wich the robot is programming to follow, determine the maximun distance the robot will travel from home.

### Input
First line of the file will contain two integers separeted by spaces: the number of obstacles and the number of commands in the robot's route, respectively.

Following lines *[number_of_obstacles]* will contain two integers separated by spaces that represent *X* and *Y* obstacle's coordinates, respectively (possitive *X*  is *East*, possitive *Y* is *North*).

Next lines *[number_of_commands]* will contain one of the commands for the robot:
- “L”: turn left 90 degrees
- “R”: turn right 90 degrees
- “M n”: Move n steps forward

### Output
The output is a float number rounded off to two decimal place, Salida un único punto flotante número redondeado a dos decimales, the maximum (Euclidean) distance the robot will get from your initial possition.

### Limits:
- 1 <= number of obstacles <= 10
- 1 <= number of commands <= 10,000
- 1 <= number of steps forward in a single command <= 10
- -100,000 <= X or Y obstacle's coordinate <= 100,000

### Input sample
- 1 8
- 0 2
- M 5
- R
- M 1
- L
- M 3
- L
- L
- M 3

### Output sample
- 4.12



![](https://i.imgur.com/RZu7uEx.png)

