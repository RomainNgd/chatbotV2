<?php

namespace Chatbot\Service;

class helperService
{

    /**
     * retourne une string de plusieurs resultat
     * @param $entity
     * @param $results
     * @return string
     */
    protected function multipleResponse($entity, $results){
        $response = 'Nous avons trouver plusieurs ' . $entity . 's pour votre demande <br/>';
        foreach ($results as $result){
            $response .= $result[$entity] . ' : <a href="'. $result["url"] .'">' . $result['url'] . '</a></br>' ;
        }
        return $response;
    }

    /**
     * retourne un string de resultat unique
     * @param $entity
     * @param $result
     * @return string
     */
    protected function simpleResponse($entity, $result){
        return 'J\'ai trouver un ' . $entity . ' correspondant à votre demande <br/>' . $result[$entity] . ' : <a href="'. $result["url"] .'">' . $result['url'] . '</a>' ;
    }
}