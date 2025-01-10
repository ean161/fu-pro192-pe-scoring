# FU PRO192 PE scoring CLI
This is a small tool to support personally in taking the exam. This tool has the function of checking the result of the .jar file (Java project) from the input file input.txt to see if it is the same as the given test result. The way it works is similar to the Object Oriented Programming (PRO192) exam scoring software, FPT University

## Author
Nguyen Hoai An - nghoaian161@gmail.com

## Usage
Create a folder containing the dataset in the *dataset* folder

In the newly created folder, contain the following components (x is the serial number of that I/O, starting from 1):
- Input file (file containing input data): *x.in.txt*
- Output file (file containing the desired data): *x.out.txt*
- Software launch file (built from the project): *Q1.jar*

The file *x.out.bak* is the result of .jar after launching and sending input to serve manual testing

## Example
Please refer to the dataset at the path *dataset/carp* (*carp* is the project name)  

### Dependencies
PHP 7.x.x - 8.x.x (recommended 8.0.3)

### Executing program
```bash
php release.php
```