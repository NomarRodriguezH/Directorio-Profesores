<?php
class StudentDashboardController {
    public function index() {
        if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'student') {
            header('Location: login.php');
            exit();
        }
        
        require_once __DIR__ . '/../models/EnrollmentModel.php';
        require_once __DIR__ . '/../models/ClassModel.php';
        require_once __DIR__ . '/../models/UserModel.php';
        require_once __DIR__ . '/../models/TeacherModel.php';
        
        $enrollmentModel = new EnrollmentModel();
        $classModel = new ClassModel();
        $userModel = new UserModel();
        $teacherModel = new TeacherModel();
        
        $correoEstudiante = $_SESSION['user_email'];
        
        // Obtener datos para el dashboard
        $user = $userModel->getUserByEmail($correoEstudiante);
        $enrollments = $enrollmentModel->getStudentEnrollments($user['id']);
        $upcomingClasses = $this->getUpcomingClasses($enrollments);
        $recentActivity = $this->getRecentActivity($user['id']);
        
        // Estadísticas
        $stats = [
            'total_clases' => count($enrollments),
            'clases_activas' => $this->countActiveEnrollments($enrollments),
            'profesores' => $this->countUniqueTeachers($enrollments),
            'proximo_horario' => $this->getNextClassTime($upcomingClasses)
        ];
        
        $page_title = "Mi Dashboard - Estudiante";
        require_once __DIR__ . '/../../frontend/views/student/dashboard.php';
    }
    
    private function getUpcomingClasses($enrollments) {
        $upcoming = [];
        $today = date('Y-m-d');
        $currentTime = date('H:i:s');
        
        foreach ($enrollments as $enrollment) {
            if ($enrollment['Estado'] === 'activo') {
                $classSchedule = $this->getClassSchedule($enrollment['IdClase_FK']);
                $nextClass = $this->findNextClassTime($classSchedule, $today, $currentTime);
                
                if ($nextClass) {
                    $upcoming[] = [
                        'clase' => $enrollment,
                        'proxima_sesion' => $nextClass
                    ];
                }
            }
        }
        
        // Ordenar por fecha más próxima
        usort($upcoming, function($a, $b) {
            return strtotime($a['proxima_sesion']['fecha'] . ' ' . $a['proxima_sesion']['hora_inicio']) - 
                   strtotime($b['proxima_sesion']['fecha'] . ' ' . $b['proxima_sesion']['hora_inicio']);
        });
        
        return array_slice($upcoming, 0, 5); // Solo las 5 próximas
    }
    
    private function getClassSchedule($idClase) {
        require_once __DIR__ . '/../models/ClassModel.php';
        $classModel = new ClassModel();
        $class = $classModel->getClassById($idClase);
        
        $schedule = [];
        $dias = ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'];
        
        foreach ($dias as $dia) {
            if (!empty($class[$dia . 'HI']) && !empty($class[$dia . 'HF'])) {
                $schedule[] = [
                    'dia' => $dia,
                    'hora_inicio' => $class[$dia . 'HI'],
                    'hora_fin' => $class[$dia . 'HF']
                ];
            }
        }
        
        return $schedule;
    }
    
    private function findNextClassTime($schedule, $currentDate, $currentTime) {
        $diasSemana = ['Lu' => 1, 'Ma' => 2, 'Mi' => 3, 'Ju' => 4, 'Vi' => 5, 'Sa' => 6, 'Do' => 7];
        $currentDay = date('N', strtotime($currentDate)); // 1 (Lunes) a 7 (Domingo)
        
        foreach ($schedule as $session) {
            $sessionDay = $diasSemana[$session['dia']];
            
            // Si la clase es hoy
            if ($sessionDay == $currentDay) {
                if ($session['hora_inicio'] > $currentTime) {
                    return [
                        'fecha' => $currentDate,
                        'hora_inicio' => $session['hora_inicio'],
                        'hora_fin' => $session['hora_fin'],
                        'dia' => $session['dia']
                    ];
                }
            }
            
            if ($sessionDay > $currentDay) {
                $daysToAdd = $sessionDay - $currentDay;
                $nextDate = date('Y-m-d', strtotime("+$daysToAdd days"));
                
                return [
                    'fecha' => $nextDate,
                    'hora_inicio' => $session['hora_inicio'],
                    'hora_fin' => $session['hora_fin'],
                    'dia' => $session['dia']
                ];
            }
        }
        
        // Si no hay clases esta semana, buscar en la siguiente
        if (!empty($schedule)) {
            $firstSession = $schedule[0];
            $daysToAdd = $diasSemana[$firstSession['dia']] + (7 - $currentDay);
            $nextDate = date('Y-m-d', strtotime("+$daysToAdd days"));
            
            return [
                'fecha' => $nextDate,
                'hora_inicio' => $firstSession['hora_inicio'],
                'hora_fin' => $firstSession['hora_fin'],
                'dia' => $firstSession['dia']
            ];
        }
        
        return null;
    }
    
    private function getRecentActivity($correoEstudiante) {
        require_once __DIR__ . '/../models/FileModel.php';
        $fileModel = new FileModel();
        
        $recentFiles = $fileModel->getRecentFilesForStudent($correoEstudiante, 5);
        
        $activity = [];
        foreach ($recentFiles as $file) {
            $activity[] = [
                'tipo' => 'archivo_nuevo',
                'mensaje' => "Nuevo archivo disponible: " . $file['NombreArchivo'],
                'clase' => $file['Materia'],
                'fecha' => $file['FechaSubida'],
                'icono' => 'bi-file-earmark-arrow-down'
            ];
        }
        
        return $activity;
    }
    
    private function countActiveEnrollments($enrollments) {
        $count = 0;
        foreach ($enrollments as $enrollment) {
            if ($enrollment['Estado'] === 'activo') {
                $count++;
            }
        }
        return $count;
    }
    
    private function countUniqueTeachers($enrollments) {
        $teachers = [];
        foreach ($enrollments as $enrollment) {
            if (!in_array($enrollment['idProfesor_FK'], $teachers)) {
                $teachers[] = $enrollment['idProfesor_FK'];
            }
        }
        return count($teachers);
    }
    
    private function getNextClassTime($upcomingClasses) {
        if (empty($upcomingClasses)) {
            return 'No hay clases programadas';
        }
        
        $nextClass = $upcomingClasses[0];
        $fecha = date('d/m/Y', strtotime($nextClass['proxima_sesion']['fecha']));
        $hora = substr($nextClass['proxima_sesion']['hora_inicio'], 0, 5);
        
        return "$fecha a las $hora";
    }
}
?>