<?php
class HRController extends Controller
{
    public function index(): string
    {
        $employeeModel   = new Employee();
        $attendanceModel = new Attendance();

        $employees   = $employeeModel->all();
        $attendances = $attendanceModel->all();

        $totalPayroll = 0.0;
        $activeCount = 0;
        $deptCounts = [];

        foreach ($employees as $emp) {
            $totalPayroll += (float)($emp['salary'] ?? 0);
            if (($emp['status'] ?? '') === 'Active') {
                $activeCount++;
            }
            $dept = $emp['department'] ?? 'General';
            $deptCounts[$dept] = ($deptCounts[$dept] ?? 0) + 1;
        }

        $todayAttendance = [];
        $presentCount = 0;
        foreach ($attendances as $att) {
            if (($att['date'] ?? '') === date('Y-m-d')) {
                $todayAttendance[] = $att;
                if (($att['status'] ?? '') === 'Present') {
                    $presentCount++;
                }
            }
        }

        return $this->view('hr.index', [
            'employees'       => $employees,
            'attendances'     => $attendances,
            'totalPayroll'    => $totalPayroll,
            'activeCount'     => $activeCount,
            'presentCount'    => $presentCount,
            'deptCounts'      => $deptCounts,
        ]);
    }

    public function storeEmployee(): void
    {
        $empModel = new Employee();
        $code = 'EMP-' . str_pad((string)(count($empModel->all()) + 1), 3, '0', STR_PAD_LEFT);

        $empModel->create([
            'employee_code' => $code,
            'full_name'     => $this->request->post('full_name'),
            'email'         => $this->request->post('email') ?: '',
            'phone'         => $this->request->post('phone') ?: '',
            'department'    => $this->request->post('department') ?: 'Operations',
            'designation'   => $this->request->post('designation') ?: 'Staff Member',
            'status'        => 'Active',
            'joining_date'  => $this->request->post('joining_date') ?: date('Y-m-d'),
            'salary'        => (float)($this->request->post('salary') ?: 50000),
        ]);

        $this->session->flash('success', "Employee {$code} onboarded successfully.");
        $this->redirect('/hr');
    }

    public function markAttendance(): void
    {
        $attModel = new Attendance();
        $empId = (int)$this->request->post('employee_id');
        $status = $this->request->post('status') ?: 'Present';

        if ($empId) {
            $attModel->create([
                'employee_id' => $empId,
                'date'        => date('Y-m-d'),
                'status'      => $status,
            ]);
            $this->session->flash('success', 'Attendance marked successfully.');
        }

        $this->redirect('/hr');
    }
}
