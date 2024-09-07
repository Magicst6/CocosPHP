<?php

class ProductGateway
{
    private PDO $conn;
    
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }
    
   
    public function create(string $Datakind,array $data): string
    {
		if ($Datakind == 'urlallowed' ) {



                $sql = "DELETE FROM AllowedWebsites
                WHERE UserID= 99999  and LehrerName = :LehrerName and LehrerMail =:LehrerMail";

                $stmt = $this->conn->prepare($sql);


                $stmt->bindValue(":LehrerName", $data["lehrername"], PDO::PARAM_INT);

            $stmt->bindValue(":LehrerMail", $data["lehrermail"], PDO::PARAM_INT);
                $stmt->execute();

                $sql = "DELETE FROM UserData
                WHERE  UserID = 99999 and LehrerName= :LehrerName and LehrerMail =:LehrerMail ";

                $stmt = $this->conn->prepare($sql);

                
                $stmt->bindValue(":LehrerName", $data["lehrername"], PDO::PARAM_INT);
           
            $stmt->bindValue(":LehrerMail", $data["lehrermail"], PDO::PARAM_INT);
                $stmt->execute();

                //  $data1 = $stmt->fetch(PDO::FETCH_ASSOC);
/*
                $sql = "SELECT url
                FROM AllowedWebsites
                WHERE pupilkey = :id and LehrerCode = :LehrerCode and LehrerName = :LehrerName";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(":id", $data["pupilkey"], PDO::PARAM_INT);
                $stmt->bindValue(":LehrerCode", $data["lehrerkey"], PDO::PARAM_INT);
                $stmt->bindValue(":LehrerName", $data["lehrername"], PDO::PARAM_INT);
                $stmt->execute();

                $data1 = $stmt->fetch(PDO::FETCH_ASSOC);


                if ($data1) {




                } else {*/
                    $sql = "INSERT INTO UserData (pupilkey,UserID,LehrerCode,LehrerName,LehrerMail)
                VALUES (:pupilkey, :userID,:LehrerCode,:LehrerName,:LehrerMail)";

                    $stmt = $this->conn->prepare($sql);

                    $stmt->bindValue(":pupilkey", $data["pupilkey"], PDO::PARAM_STR);
                    $stmt->bindValue(":userID", 99999 ?? 0, PDO::PARAM_STR);
                    $stmt->bindValue(":LehrerCode", $data["lehrerkey"] ?? 0, PDO::PARAM_STR);
                    $stmt->bindValue(":LehrerName", $data["lehrername"], PDO::PARAM_INT);
                    $stmt->bindValue(":LehrerMail", $data["lehrermail"], PDO::PARAM_INT);
                    $stmt->execute();

                //}
                $sql = "INSERT INTO AllowedWebsites (pupilkey,url,LehrerCode,UserID,LehrerName,LehrerMail)
                VALUES (:pupilkey, :urlcoded,:LehrerCode,99999,:LehrerName,:LehrerMail)";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(":pupilkey", $data["pupilkey"], PDO::PARAM_STR);
                $stmt->bindValue(":urlcoded", $data["urlcoded"] ?? 0, PDO::PARAM_STR);
                $stmt->bindValue(":LehrerCode", $data["lehrerkey"] ?? 0, PDO::PARAM_STR);
                $stmt->bindValue(":LehrerName", $data["lehrername"] ?? 0, PDO::PARAM_STR);
                $stmt->bindValue(":LehrerMail", $data["lehrermail"], PDO::PARAM_INT);

                $stmt->execute();

                return $this->conn->lastInsertId();
            }

        if ($Datakind == 'onlinestatus' ) {

            $sql = "SELECT *
                FROM OnlineStatus
                WHERE pupilkey = :id and Name = :PupilName";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $data["pupilkey"], PDO::PARAM_INT);
            $stmt->bindValue(":PupilName", $data["sname"], PDO::PARAM_INT);

            $stmt->execute();

            $data1 = $stmt->fetch(PDO::FETCH_ASSOC);


            if ($data1) {


            $sql = "UPDATE OnlineStatus SET OnlineStatus = :OnlineStatus, Date= :Date 
            WHERE pupilkey = :id and Name = :PupilName";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $data["pupilkey"], PDO::PARAM_INT);
            $stmt->bindValue(":PupilName", $data["sname"], PDO::PARAM_INT);
            $stmt->bindValue(":OnlineStatus", $data["onlinestatus"], PDO::PARAM_INT);
            $stmt->bindValue(":Date", $data["date"], PDO::PARAM_INT);

                $stmt->execute();
            }else{
                $sql = "INSERT INTO OnlineStatus (pupilkey,Name,OnlineStatus,Date)
                VALUES (:id, :PupilName,:OnlineStatus,:Date)";

                $stmt = $this->conn->prepare($sql);

                $stmt->bindValue(":id", $data["pupilkey"], PDO::PARAM_INT);
                $stmt->bindValue(":PupilName", $data["sname"], PDO::PARAM_INT);
                $stmt->bindValue(":OnlineStatus", $data["onlinestatus"], PDO::PARAM_INT);
                $stmt->bindValue(":Date", $data["date"], PDO::PARAM_INT);

                $stmt->execute();

                return $this->conn->lastInsertId();

            }
        }if ($Datakind == 'onlinestatusdel' ) {
        $sql = "DELETE FROM OnlineStatus
                WHERE pupilkey = :id and Name = :PupilName";

        $stmt = $this->conn->prepare($sql);


        $stmt->bindValue(":id", $data["pupilkey"], PDO::PARAM_INT);
        $stmt->bindValue(":PupilName", $data["sname"], PDO::PARAM_INT);
        $stmt->execute();
    }



        return 'null';
    }
    
    public function get(string $Datakind ,string $id ): array | false
    {
		if ($Datakind == 'urlallowed' ){
        $sql = "SELECT url,LehrerCode
                FROM AllowedWebsites
                WHERE pupilkey = :id ";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        
        $stmt->execute();
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);


            return $data;
		

		}
		if ($Datakind == 'userdata' ){
            $sql = "SELECT LehrerName,LehrerMail,LehrerCode
                FROM UserData
                WHERE pupilkey = :id ";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(":id", $id, PDO::PARAM_INT);


            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
		return null;
    }
    
    public function update(string $Datakind,array $current, array $new): int
    {
       if ($Datakind == 'Noten' ){
		
		$sql = "UPDATE sv_Noten
                SET Name = :Name
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":Name", $new["name"] ?? $current[0]["name"], PDO::PARAM_STR);
      
        
        $stmt->bindValue(":id", $current[0]["ID"], PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
		return null;
	}
    
    public function delete(string $Datakind,string $id): int
    {
       if ($Datakind == 'Noten' ){
		$sql = "DELETE FROM sv_Noten
                WHERE id = :id";
                
        $stmt = $this->conn->prepare($sql);
        
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->rowCount();
    }
		return null;
	}
}











