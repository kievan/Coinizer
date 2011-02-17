<?php

    /*
     * File:   coinizer.php
     * Author: Artyom Gordiyevsky
     * Date:   2011-02-17T12:42:23.000+01:00
     */

//    (int)$amount    = $_REQUEST["amount"];
//    $coinTypes = $_REQUEST["coinTypes"];
//    $coinTypesArr = explode( "|", $coinTypes );

    $amount = 13;
    $coinTypesArr = array(3,7);

    $format = "Input:\nCoin amount: %s\nCoint types: %s\n\nOutput:\n";
    printf($format,$amount,implode(",",$coinTypesArr));

    var_dump( getLeastCoinNumber( $amount, $coinTypesArr ) );

    function getLeastCoinNumber( $amount, $coinTypes )
    {
        $leastCoinNumCollection = array();
        /*
         * Sort coin types in reverse (descending) order
         * leaving the associative indeces intact.
         */
        rsort( $coinTypes );

        /*
         * 1) run a loop for all coin types
         * 2) compute the remainder from dividing of the current
         *    coin type into the current amount
         * 3) if current amount is bigger than or equal to the
         *    current coin type and if the current amount is
         *    bigger than 0 then continue
         *    3.1) compute number of coins of the current coin type
         *    3.2) contruct a "current coin type" + "current
         *         coin type number" pair
         *    3.3) add the above pair to a collection
         *    3.4) compute the amount for the next iteration
         */
        for( $i=0; $i<count( $coinTypes ); $i++ )
        {
            $remainder = $amount%$coinTypes[$i];

            if( $amount >= $coinTypes[$i] && $amount > 0 )
            {
                $coinNum = $amount/$coinTypes[$i];
                $coinTypeNumPair = "Coin type: ".$coinTypes[$i].
                                   ", Number of coins: ".(int)$coinNum;
                array_push( $leastCoinNumCollection, $coinTypeNumPair );
                $amount -= ( $amount - $remainder );
            }
        }

        /*
         * If the amount manages to be larger than zero, assume the least coin
         * type could not divide the remaing amount without remainder.
         * Assumming that there will always be 1 unit coins in stock add
         * the final coin type+coin number pair to the collection.
         */
        if( $amount > 0 )
        {
                $coinTypeNumPair = "Coin type: 1".
                                   ", Number of coins: $amount";
                array_push( $leastCoinNumCollection, $coinTypeNumPair );
        }

        return $leastCoinNumCollection;
    }

?>

