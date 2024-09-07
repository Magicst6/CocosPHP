<?php

class ProductController
{
    public function __construct(private ProductGateway $gateway)
    {
    }


    public function processRequest(string $Datakind, string $method, ?string $id, ?string $lkey,?string $urlcoded,?string $lname,?string $lmail): void
    {
        if (!$urlcoded) {
            
            $this->processResourceRequest($Datakind,$method, $id);
            
        } else {
            
            $this->processCollectionRequest($Datakind,$method,$id,$lkey,$urlcoded,$lname,$lmail);
            
        }
    }

    public function processRequestOS(string $Datakind, string $method, ?string $id, ?string $sname,?string $onlinestatus,?string $date): void
    {


            $this->processCollectionRequestOS($Datakind,$method,$id,$sname,$onlinestatus,$date);


    }

 
    private function processResourceRequest( string $Datakind,string $method, string $id): void
    {
        $Dataset = $this->gateway->get($Datakind,$id);
        
        if ( ! $Dataset) {
            http_response_code(404);
            echo json_encode(["message" => "Dataset not found"]);
            return;
        }
        
		
		
        switch ($method) {
            case "GET":
                echo json_encode($Dataset);
                break;
                
            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                
                $errors = $this->getValidationErrors($data, false);
                
                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $rows = $this->gateway->update($Datakind,$Dataset, $data);
                
                echo json_encode([
                    "message" => "Dataset $Datakind $id updated",
                    "rows" => $rows
                ]);
                break;
                
            case "DELETE":
                $rows = $this->gateway->delete($Datakind,$id);
                
                echo json_encode([
                    "message" => "Dataset $Datakind $id deleted",
                    "rows" => $rows
                ]);
                break;
                
            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE, POST");
        }
    }


    private function processCollectionRequest(string $Datakind,string $method,string $pupilkey,string $lehrerkey,string $urlcoded,string $lname, string $lmail):void
    {
        switch ($method) {
            case "GET":
                 json_encode($this->gateway->getAll($Datakind));
                break;
                
            case "POST":
				
                $data['pupilkey'] = $pupilkey;
                $data['urlcoded'] = $urlcoded;
                $data['lehrerkey'] = $lehrerkey;
                $data['lehrername'] = $lname;
                $data['lehrermail'] = $lmail;
                
                $errors = $this->getValidationErrors($data);
                
                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }
                
                $message = $this->gateway->create($Datakind,$data);

               if ($message=="Der generierte Key existiert bereits.Aktion wiederholen!!")
               {
                   http_response_code(501);
                   break;
               }
               http_response_code(201);
                /*if ($message) {
                     echo json_encode([
                        "message" => "$Datakind Dataset created",
                        "id" => $id
                    ]);*/

                 echo $message;
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function processCollectionRequestOS(string $Datakind,string $method,string $pupilkey,string $sname,string $onlinestatus,string $date):void
    {
        switch ($method) {
            case "GET":
                json_encode($this->gateway->getAll($Datakind));
                break;

            case "POST":

                $data['pupilkey'] = $pupilkey;
                $data['sname'] = $sname;
                $data['onlinestatus'] = $onlinestatus;
                $data['date'] = $date;
                

                $errors = $this->getValidationErrors($data);

                if ( ! empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $message = $this->gateway->create($Datakind,$data);

                if ($message=="Der generierte Key existiert bereits.Aktion wiederholen!!")
                {
                    http_response_code(501);
                    break;
                }
                http_response_code(201);
                /*if ($message) {
                     echo json_encode([
                        "message" => "$Datakind Dataset created",
                        "id" => $id
                    ]);*/

                echo $message;
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }


    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];
        
        if ($is_new && empty($data["name"])) {
           // $errors[] = "name is required";
        }
        
        if (array_key_exists("size", $data)) {
            if (filter_var($data["size"], FILTER_VALIDATE_INT) === false) {
            //    $errors[] = "size must be an integer";
            }
        }
        
        return $errors;
    }
}









