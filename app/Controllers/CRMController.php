<?php
class CRMController extends Controller
{
    public function index(): string
    {
        $leadModel     = new Lead();
        $customerModel = new Customer();

        $leads     = $leadModel->all();
        $customers = $customerModel->all();

        $pipelineValue = 0.0;
        $oppCount = 0;
        $convertedCount = 0;

        foreach ($leads as $lead) {
            $pipelineValue += (float)($lead['estimated_value'] ?? 0);
            $status = $lead['status'] ?? 'Lead';
            if ($status === 'Opportunity') {
                $oppCount++;
            } elseif ($status === 'Converted') {
                $convertedCount++;
            }
        }

        return $this->view('crm.index', [
            'leads'          => $leads,
            'customers'      => $customers,
            'pipelineValue'  => $pipelineValue,
            'oppCount'       => $oppCount,
            'convertedCount' => $convertedCount,
        ]);
    }

    public function storeLead(): void
    {
        $leadModel = new Lead();
        $leadModel->create([
            'name'            => $this->request->post('name'),
            'company'         => $this->request->post('company') ?: '',
            'email'           => $this->request->post('email') ?: '',
            'phone'           => $this->request->post('phone') ?: '',
            'status'          => $this->request->post('status') ?: 'Lead',
            'source'          => $this->request->post('source') ?: 'Website',
            'estimated_value' => (float)($this->request->post('estimated_value') ?: 0),
            'notes'           => $this->request->post('notes') ?: '',
        ]);

        $this->session->flash('success', 'New lead captured into CRM pipeline.');
        $this->redirect('/crm');
    }

    public function updateStatus(): void
    {
        $leadId = (int)$this->request->post('id');
        $status = $this->request->post('status');

        if ($leadId && $status) {
            $leadModel = new Lead();
            $leadModel->update($leadId, ['status' => $status]);
            $this->session->flash('success', "Lead status changed to {$status}.");
        }

        $this->redirect('/crm');
    }
}
