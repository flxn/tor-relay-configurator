<?php
class TRCStats
{
    private $db;

    function __construct()
    {
        $this->db = new PDO('sqlite:trc.db');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getNodesOverTime($days = -1)
    {
        $data = array();
        $limit = $days > 0 ? $days * 12 : -1;
        try {
            $result = $this->db->query("
                SELECT measured, count(*) 
                FROM (
                    SELECT node, measured FROM stats GROUP BY node, strftime('%Y-%m-%d',measured)
                )
                GROUP BY strftime('%Y-%m-%d',measured)
                ORDER BY strftime('%Y-%m-%d',measured) DESC 
                LIMIT $limit");
            foreach ($result as $row) {
                $data[] = array("x" => $row[0], "y" => intval($row[1]));
            }
        } catch (PDOException $e) {
                echo $e->getMessage();
        }
        return $data;
    }

    public function getBandwidthOverTime($days = -1)
    {
        $data = array();
        $limit = $days > 0 ? $days * 12 : -1;
        try {
            $result = $this->db->query("
                SELECT datetime(measured), sum(bw) 
                FROM (
                    SELECT min(average_bandwidth, burst_bandwidth, observed_bandwidth) as bw, measured FROM stats
                ) 
                GROUP BY strftime('%Y-%m-%d %H',measured) 
                ORDER BY strftime('%Y-%m-%d %H',measured) DESC 
                LIMIT $limit");
            foreach ($result as $row) {
                $data[] = array("x" => $row[0], "y" => round(intval($row[1]) * 8 / 1000 / 1000));
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
        }
        return $data;
    }
}