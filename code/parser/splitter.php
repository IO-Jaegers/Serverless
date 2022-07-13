<?php
    /**
     * Takes the input data and makes a word list of it
     */
    mb_internal_encoding( 'UTF-8' );


    /**
     * 
     */
    function outputResult( array $values ): string
    {
        return utf8_encode( 
            json_encode( $values ) 
        );
    }

    function illegal_char( string $str ): bool
    {
        return str_contains( $str, '[' )|| str_contains( $str, ']' ) || str_contains( $str, '#' );
    }


    /**
     * 
     */
    function split( string $set ): array
    {
        $retValues = [];

        $exploded = mb_split( ' ', $set );

        $idx = 0;
        $size_of = count( $exploded );

        // 
        for( $idx = 0; 
             $idx < $size_of; 
             $idx++ )
        {
            $current = $exploded[$idx];

            $illegal_char = illegal_char( $current );

            if( !$illegal_char )
            {
                $current = mb_strtolower( $current );
                $current = str_replace( array( "\r", "\n", "\"", "-", ".", ",", "*", ":", "_", ";" ), ' ', $current );

                array_push( $retValues, $current );
            }
        }

        return $retValues;
    }

    function final_split( array $values ): array
    {
        $ret = [];

        $size_of = count( $values );
        $idx = 0;

        for( $idx = 0; 
             $idx < $size_of; 
             $idx++ )
        {
            $current = $values[$idx];

            $explode = mb_split( ' ', $current );
            $size_of_ex = count( $explode );

            for( $idxEx = 0; 
                 $idxEx < $size_of_ex; 
                 $idxEx++ )
            {
                array_push( $ret, $explode[ $idxEx ] );
            }
        }

        return $ret;
    }


    /**
     * 
     */
    function removeWordsBelowThresshold( array $values ): array
    {
        $ret = [];

        $size_of = count( $values );
        $idx = 0;

        for( $idx = 0; 
             $idx < $size_of; 
             $idx++ )
        {
            $current = $values[$idx];
            $str_length = mb_strlen( $current );

            if( $str_length >= 20 )
            {
                array_push( $ret, $current );
            }
        }

        return $ret;
    }


    /**
     * 
     */
    function removeRedundanciesAndOther( array $values ): array
    {
        $retValues = [];

        $arr_size = sizeof( $values );


        for( $index = 0;
             $index < $arr_size;
             $index++ )
        {
            $current = $values[$index];
            $remove = false;

            if( empty( $current ) )
            {
                $remove = true;
            }

            // 
            if( !$remove )
            {
                array_push( $retValues, $current );
            }
        }

        return $retValues;
    }

    function orderWordSet( array $values ): array
    {
        $sV = $values;
        $n = sort($sV, SORT_STRING);
        return $sV;
    }


    /**
     * Executes Function, Is main
     */
    function main( array $arguments ) : array
    {
        if( $arguments[ '__ow_method' ] == 'post' )
        {
            $body = utf8_decode( $arguments[ '__ow_body' ] );

            $tokens = split( $body );

            $filtered_tokens = removeWordsBelowThresshold( $tokens );
            unset( $tokens );

            $filtered_tokens = final_split( $filtered_tokens );

            $words = removeRedundanciesAndOther( $filtered_tokens );
            unset( $filtered_tokens );

            // Output value
            return [ "body" => outputResult( 
                orderWordSet( $words ) 
            ) ];
        }
        
        throw new Exception( 'wrong http type used' );
    }
?>