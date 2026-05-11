@extends('layouts.app')

@section('sidebar')
    @include('layouts.partials.hr_employee_sidebar')
@endsection

@section('title', 'Create Job Requisition')
@section('header-title', 'Create Job Requisition')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/jobrequisitiondetails.css') }}">
@endpush

@section('content')
  <div class="page-wrapper">
    <div class="mb-4">
      <a href="{{ route('hr_employee.job-requisitions') }}" class="text-muted text-decoration-none small mb-2 d-inline-block">← Back to Requisitions</a>
      <h1 class="text-white">Create Job Requisition</h1>
    </div>

    <form onsubmit="event.preventDefault(); window.location.href='{{ route('hr_employee.job-requisitions') }}';">
      
      <!-- Section 1: Job Details -->
      <div class="card bg-card border-card mb-4">
        <div class="card-header border-bottom border-card p-4">
          <h2 class="h5 text-white mb-0">Job Details</h2>
        </div>
        <div class="card-body p-4">
          <div class="row g-4">
            <div class="col-md-6">
              <label class="form-label text-white">Job Title</label>
              <input type="text" class="form-control custom-input" required placeholder="e.g. Senior Frontend Developer">
            </div>
            <div class="col-md-6">
              <label class="form-label text-white">Department</label>
              <select class="form-select custom-select" required>
                <option value="" disabled selected>Select department</option>
                <option value="Engineering">Engineering</option>
                <option value="Product">Product</option>
                <option value="Design">Design</option>
                <option value="Marketing">Marketing</option>
                <option value="HR">HR</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label text-white">Job Type</label>
              <select class="form-select custom-select" required>
                <option value="" disabled selected>Select type</option>
                <option value="Full-time">Full-time</option>
                <option value="Part-time">Part-time</option>
                <option value="Contract">Contract</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label text-white">Work Mode</label>
              <select class="form-select custom-select" required>
                <option value="" disabled selected>Select mode</option>
                <option value="Remote">Remote</option>
                <option value="On-site">On-site</option>
                <option value="Hybrid">Hybrid</option>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label text-white">Seniority Level</label>
              <select class="form-select custom-select" required>
                <option value="" disabled selected>Select level</option>
                <option value="Junior">Junior</option>
                <option value="Mid-level">Mid-level</option>
                <option value="Senior">Senior</option>
                <option value="Lead">Lead</option>
                <option value="Manager">Manager</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-white">Salary Range</label>
              <div class="input-group">
                <span class="input-group-text custom-input-group-text">$</span>
                <input type="number" class="form-control custom-input" placeholder="From" required>
                <span class="input-group-text custom-input-group-text border-start-0 border-end-0 bg-input text-muted">-</span>
                <span class="input-group-text custom-input-group-text">$</span>
                <input type="number" class="form-control custom-input" placeholder="To" required>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label text-white">Years of Experience Required</label>
              <input type="number" class="form-control custom-input" min="0" required placeholder="e.g. 5">
            </div>
            <div class="col-12">
              <label class="form-label text-white">Skills Required</label>
              <input type="text" class="form-control custom-input" required placeholder="e.g. React, TypeScript, Node.js">
            </div>
            <div class="col-12">
              <label class="form-label text-white">Job Description</label>
              <textarea class="form-control custom-input" rows="5" required placeholder="Detailed description..."></textarea>
            </div>
          </div>
        </div>
      </div>

      <!-- Section 2: Candidate Progression Rules -->
      <div class="card bg-card border-card mb-4">
        <div class="card-header border-bottom border-card p-4">
          <h2 class="h5 text-white mb-1">Candidate Progression Rules</h2>
          <p class="text-white mb-0 small">Set minimum score thresholds for candidates to advance to the next stage.</p>
        </div>
        <div class="card-body p-4">
          <div class="d-flex flex-column gap-3">
            
            <div class="card bg-input border-card">
              <div class="card-body d-flex align-items-center justify-content-between p-3 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="bg-card p-2 rounded border border-card">📄</div>
                  <div>
                    <strong class="text-white d-block">Application → Exam</strong>
                    <span class="text-muted small">Minimum application score to proceed to exam stage</span>
                  </div>
                </div>
                <div style="width: 100px;">
                  <input type="number" class="form-control custom-input text-center" value="60" min="0" max="100" required>
                </div>
              </div>
            </div>

            <div class="card bg-input border-card">
              <div class="card-body d-flex align-items-center justify-content-between p-3 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="bg-card p-2 rounded border border-card">✍️</div>
                  <div>
                    <strong class="text-white d-block">Exam → Interview</strong>
                    <span class="text-muted small">Minimum exam score to proceed to interview stage</span>
                  </div>
                </div>
                <div style="width: 100px;">
                  <input type="number" class="form-control custom-input text-center" value="70" min="0" max="100" required>
                </div>
              </div>
            </div>

            <div class="card bg-input border-card">
              <div class="card-body d-flex align-items-center justify-content-between p-3 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="bg-card p-2 rounded border border-card">🗣️</div>
                  <div>
                    <strong class="text-white d-block">Interview → Offer</strong>
                    <span class="text-muted small">Minimum interview score to receive an offer</span>
                  </div>
                </div>
                <div style="width: 100px;">
                  <input type="number" class="form-control custom-input text-center" value="75" min="0" max="100" required>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Section 3: Exam Template Configuration -->
      <div class="card bg-card border-card mb-4">
        <div class="card-header border-bottom border-card p-4">
          <h2 class="h5 text-white mb-1">Exam Template Configuration</h2>
          <p class="text-white mb-0 small">Configure auto-generated assessment question counts.</p>
        </div>
        <div class="card-body p-4">
          <div class="table-responsive">
            <table class="table table-borderless align-middle custom-table">
              <thead>
                <tr>
                  <th class="text-muted fw-medium w-25">Question Type</th>
                  <th class="text-muted text-center fw-medium">Easy</th>
                  <th class="text-muted text-center fw-medium">Medium</th>
                  <th class="text-muted text-center fw-medium">Hard</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="text-white">Multiple Choice (MCQ)</td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="5" min="0" style="max-width: 80px;"></td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="5" min="0" style="max-width: 80px;"></td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="3" min="0" style="max-width: 80px;"></td>
                </tr>
                <tr>
                  <td class="text-white">Written / Essay</td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="1" min="0" style="max-width: 80px;"></td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="2" min="0" style="max-width: 80px;"></td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="1" min="0" style="max-width: 80px;"></td>
                </tr>
                <tr>
                  <td class="text-white">Coding / Practical</td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="1" min="0" style="max-width: 80px;"></td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="1" min="0" style="max-width: 80px;"></td>
                  <td><input type="number" class="form-control custom-input text-center mx-auto q-input" value="1" min="0" style="max-width: 80px;"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="mt-3 p-3 bg-input border border-card rounded d-flex justify-content-between align-items-center">
            <span class="text-white fw-medium">Total Questions:</span>
            <span class="text-warning fw-bold fs-4" id="totalQuestions">20</span>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-end gap-3 pb-4">
        <button type="button" class="btn btn-outline-light px-4">Save Draft</button>
        <button type="submit" class="btn btn-warning custom-btn-primary px-4 fw-medium">Submit for Approval</button>
      </div>

    </form>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('js/jobrequisitiondetails.js') }}"></script>
@endpush