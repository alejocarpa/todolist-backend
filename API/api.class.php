<?php 

class Api {
    
    public function fncResponse($response){
        
        if(!empty($response)){
            
            $json = array(
                
                'status' => 200,
                'total' => count($response),
                'results' => $response
            );
            
        }else{
            
            $json = array(
                
                'status' => 404,
                'results' => 'Not found',
                'method' => 'get'
            );
            
        }
        
        echo json_encode($json);
        
    }
}

?>