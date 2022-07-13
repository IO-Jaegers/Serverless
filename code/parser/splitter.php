<?php
    mb_internal_encoding( 'UTF-8' );

    /**
     * Takes the input data and makes a word list of it
     */

    /**
     * 
     */
    function outputResult( array $values ): string
    {
        
        
        
        
        return 'test';
    }


    /**
     * 
     */
    function split( string $set ): array
    {
        $retValues = [];

        $exploded = mb_split( ' ', $set );

        $idx = 0;

        for( $idx = 0; 
             $idx < count( $exploded ); 
             $idx++ )
        {
            $exploded[$idx] = mb_strtolower( $exploded[ $idx ] );
        }

        return $retValues;
    }


    /**
     * 
     */
    function removeRedundancies( array $values ): array
    {
        $retValues = [];

        return $retValues;
    }


    /**
     * Executes Function, Is main
     */
    function main( array $arguments ) : array
    {
        if( $arguments[ '__ow_method' ] == 'post' )
        {
            $body = $arguments[ '__ow_body' ];

            $tokens = split( $body );
            unset( $body );

            $words = removeRedundancies( $tokens );
            unset( $tokens );

            // Output value
            return [ "body" => outputResult( $words ) ];
        }
        
        throw new Exception( 'wrong http type used' );
    }
?>