<?php

class GlobalParam {
    
    private $data;
    private $id;
    
    public function __construct($row, $new = false) {
        global $pdo;
        $i = 0;
        foreach ($row as $key => $value) {
            if ($i == 0 && $value != null && $new == false) {
                $this->id = $value;
            }
            $this->$key = $value;
            $i++;
        }
    }

    public function save() {
        global $pdo;

        $class = strtolower(get_class($this));

        if (!empty($this->id)) {
            $sql = " UPDATE global_param SET ";
            $set = array();

            foreach ($this->data as $att => $value)
                if ($att != 'id' && $att != 'id_global_param' && $value)
                    $set[] = " $att = " . $pdo->quote($value) . " ";

            $sql .= implode(",", $set);
            $sql .= " WHERE id_global_param =" . $this->id;
            $last_id = $this->id;
            try {
                $pdo->exec($sql);
            } catch (PDOException $e) {
                echo $e;
            }
        } else {

            $sql = " INSERT INTO global_param ";
            $sql .= "(" . implode(",", array_keys($this->data)) . ") ";
            foreach (array_values($this->data) as $value)
                $values[] = $pdo->quote($value);
            $sql .= "values (" . implode(",", array_values($values)) . ")";

            try {
                $pdo->exec($sql);
            } catch (PDOException $e) {
                echo "Erreur d'insert : " . $e;
            }

            $query = "SELECT id_global_param FROM global_param ORDER BY id_global_param DESC LIMIT 0 , 1";
            try {
                $stmt = $pdo->query($query);
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Erreur de select : " . $e;
            }

            if ($res === false)
                return false;

            $last_id = $res[0]["id_global_param"];
        }

        return $last_id == false ? NULL : $last_id;
    }

    public function __get($prop) {
        if ($prop == 'id') {
            return $this->data['id_global_param'];
        } else {
            return htmlspecialchars($this->data[$prop]);
        }
    }

    public function __set($prop, $value) {
        $this->data[$prop] = $value;
    }

}
