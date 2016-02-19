<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OptimizationAlgorithmPsudocode
 *
 * @author Sierra
 */
class OptimizationAlgorithmPsudocode {
    /*code to pick the best date/time BASIC TEMPLATE
     * 
     * AVAILABILITY
     *  -Schedule for multiple parties
     *  -input in one schedile
     *  -compare schedules one section at a time 
     * 
     *  24 hours, 7 days per week, 24X7 matrix, each row is a different day
     * Have each scedule be inputed as matrix, starting from Sunday 12am-1am = (0,0) and ending at Saturday 11pm-12am (7, 24)
     * We can eliminate the hours to search for by having the user input limits (ie no Night Hours, etc)
     *      -it shortens the list necessary to search through for comparison
     *      - Stick a 0 in the slot for unavailable, 1 for available 
     *  
     * add up the matrices together, the date/time with the biggest number is the winner.
     * 
     * AdditionMatrix(Matrix A, B, N)
     *  For (int i =0; i <7; i++) ROW{
     *      For(j =0; j<24; j++) COLUMN {
     *          Matrix P(i,j) = A(i,j) + B(i,j) + .... + N(i,j);
     *      end
     *  end
     *       
     * Go throught the seperate Matrix to see the largest 3 numbers and but them in ints 1st, 2nd, and 3rd
     *
     *  
     *  
     * 
     * 
     * 
     * 
     *  SortingTopThree(int A, B, C)
     * {    int a =A;
     *      int b = B;
     *      int c = C;
     * 
     *      if (a<b){
     *           int j = a;
     *           a = b;
     *           b =j;
     *      if (b<c)
     *           j = b;
     *           b = c;
     *           c = j;
     *      if (a<b){
     *           int j = a;
     *           a = b;
     *           b =j;   
     * }     * 
     * 
     * Once decided, show the top 3 on the individual list as the possible options.
     * 
     * 
     * 
    */
    
    
    
    
    
    
    
    
    
}
