<?php
class Core_View_Helper_Schedue
{
    public function schedue()
    {
        return $this;
        
    }
    
    public function compileLessons($lessons){
        $scheduleSettingsModel = new Model_Schedule_Settings();
        
        $work_days = $scheduleSettingsModel->work_days;
        $weeks_cycle = $scheduleSettingsModel->weeks_cycle;
        
        $days = array_keys($work_days);
        
        $schedue = array();
        
        foreach ( $work_days as $day => $_lessons ) {
            for ($i = 1; $i <= $_lessons; $i ++) {
                
                $schedue[$day][$i] = array_fill(0, $weeks_cycle, null);
                
            }
        }
        
        foreach ( $lessons as $day => $lesson ) {
            if ( $day <= count($days) ) {
                $key = $day-1;
            }
            else  {
                $key = ($day - count($days))-1;
            }
            
            foreach ( $lesson as $lkey => $hour ) {
                $cycle = ceil($day / count($days)) - 1;
                $schedue[$days[$key]][$lkey][$cycle] = $hour;
            }
            $key ++;
        }
        
        return $schedue;
    }
    
    public function getTitle($unit, $type = 'teacher') {
        if ( $type == 'teacher' ) {
            $employeeModel = new Model_User();
            
            $teacher = $employeeModel->get($unit);
            
            return $teacher['lastname'] . ' ' . $teacher['name'] . ' ' . $teacher['patronymic'];
        }
        else {
            $groupModel = new Model_Glossary('group');
            
            $group = $groupModel -> get($unit);
            
            return $group['name'];
        }
    }
}