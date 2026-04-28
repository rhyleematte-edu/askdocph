@extends('layouts.admin')

@section('title', 'Admin - Application Details')

@push('styles')
<style>
/* ── Admin Application Detail – Light Mode ─────────────────── */
@keyframes floatIn {
    0%   { opacity: 0; transform: translateY(18px); }
    100% { opacity: 1; transform: translateY(0); }
}

.admin-body { padding: 32px 24px; min-height: 100vh; background: var(--adm-bg); }

/* Main panel */
.glass-panel {
    background: var(--adm-panel);
    border: 1px solid var(--adm-border);
    border-radius: 20px;
    padding: 32px;
    box-shadow: var(--adm-shadow-sm);
    animation: floatIn 0.5s cubic-bezier(0.16,1,0.3,1) both;
    margin: 0 auto;
    max-width: 1200px;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--adm-border-2);
}
.header-top h1 {
    font-size: 1.7rem;
    font-weight: 800;
    margin: 0;
    color: var(--adm-text);
    letter-spacing: -0.3px;
}

/* Badges */
.badge {
    padding: 5px 13px;
    border-radius: 20px;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    letter-spacing: 0.5px;
}
.badge.pending  { background: rgba(245,158,11,0.12); color: #d97706; border: 1px solid rgba(245,158,11,0.35); }
.badge.approved { background: rgba(16,185,129,0.12); color: #059669; border: 1px solid rgba(16,185,129,0.35); }
.badge.rejected { background: rgba(239,68,68,0.10);  color: #dc2626; border: 1px solid rgba(239,68,68,0.3);  }

/* Section label */
.section-title {
    font-size: 0.75rem;
    font-weight: 800;
    color: var(--adm-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 16px;
    display: block;
}

/* Info cards */
.glass-card {
    background: var(--adm-thead-bg);
    border: 1px solid var(--adm-border);
    border-radius: 16px;
    padding: 22px;
    margin-bottom: 32px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.glass-card:hover { border-color: rgba(124,58,237,0.25); box-shadow: var(--adm-shadow-row); }

.detail-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 22px; }
.detail-item strong {
    display: block;
    color: var(--adm-muted);
    font-size: 0.72rem;
    margin-bottom: 6px;
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.detail-item span { font-size: 1rem; color: var(--adm-text); font-weight: 600; }

/* Document list items */
.document-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 20px;
    background: var(--adm-panel);
    border: 1.5px solid var(--adm-border);
    border-radius: 12px;
    margin-bottom: 10px;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.document-item:hover { border-color: rgba(124,58,237,0.25); box-shadow: 0 3px 12px rgba(15,23,42,0.05); }
.doc-name  { font-weight: 700; color: var(--adm-text); margin-bottom: 5px; font-size: 1rem; }
.doc-desc  { font-size: 0.84rem; color: var(--adm-muted); }

/* View file button */
.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 15px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 0.84rem;
    font-weight: 700;
    color: #2563eb;
    background: rgba(37,99,235,0.08);
    border: 1.5px solid rgba(37,99,235,0.25);
    transition: all 0.2s;
}
.btn-outline:hover { background: rgba(37,99,235,0.15); transform: translateY(-1px); }

/* Action bar */
.action-bar {
    display: flex;
    gap: 14px;
    justify-content: flex-end;
    margin-top: 36px;
    padding-top: 28px;
    border-top: 1px solid var(--adm-border);
}

.btn-solid {
    padding: 12px 26px;
    border-radius: 12px;
    border: none;
    font-weight: 800;
    font-size: 0.94rem;
    cursor: pointer;
    color: #fff;
    transition: all 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.btn-approve { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 14px rgba(16,185,129,0.28); }
.btn-approve:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(16,185,129,0.38); }
.btn-reject  { background: linear-gradient(135deg, #ef4444, #dc2626); box-shadow: 0 4px 14px rgba(239,68,68,0.28); }
.btn-reject:hover  { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(239,68,68,0.38); }

/* Notes box – Review history card */
.notes-box {
    background: var(--adm-panel);
    border: 1px solid var(--adm-border);
    padding: 20px 22px;
    border-radius: 14px;
    border-left: 4px solid var(--adm-border);
    box-shadow: var(--adm-shadow);
    transition: background 0.25s, border-color 0.25s;
}
.notes-box-title {
    font-size: 1rem;
    font-weight: 800;
    color: var(--adm-text);
    display: flex;
    align-items: center;
    gap: 7px;
}
.notes-box-date {
    font-size: 0.82rem;
    color: var(--adm-muted);
    font-weight: 600;
}
.notes-box-body {
    white-space: pre-wrap;
    margin: 12px 0 0;
    color: var(--adm-text);
    line-height: 1.7;
    font-size: 0.94rem;
    padding: 14px 16px;
    background: var(--adm-hover);
    border-radius: 10px;
    border: 1px solid var(--adm-border-2);
}

/* Back link */
.back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--adm-muted);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.88rem;
    margin-bottom: 22px;
    transition: color 0.2s;
}
.back-link:hover { color: var(--adm-grad-a); }

/* ── Modals ─────────────────────────────────────────────────── */
.glass-modal-backdrop {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(15,23,42,0.5);
    backdrop-filter: blur(6px);
    z-index: 2000;
    display: none;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.25s;
}
.glass-modal-backdrop.open { display: flex; opacity: 1; }

.glass-modal {
    background: var(--adm-panel);
    border: 1px solid var(--adm-border);
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    padding: 30px;
    box-shadow: 0 20px 50px rgba(15,23,42,0.18);
    transform: scale(0.96) translateY(14px);
    transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
}
.glass-modal-backdrop.open .glass-modal { transform: scale(1) translateY(0); }

.modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.modal-header h2 { font-size: 1.35rem; font-weight: 800; color: var(--adm-text); margin: 0; }
.modal-close { background: none; border: none; color: var(--adm-muted); cursor: pointer; transition: color 0.2s; padding: 4px; border-radius: 6px; }
.modal-close:hover { color: var(--adm-text); background: var(--adm-hover); }

.form-group { margin-bottom: 18px; }
.form-group label { display: block; margin-bottom: 7px; font-weight: 700; color: var(--adm-text); font-size: 0.88rem; }
.form-control {
    width: 100%;
    background: var(--adm-input-bg);
    border: 1.5px solid var(--adm-border);
    padding: 13px 15px;
    border-radius: 12px;
    color: var(--adm-text);
    font-size: 0.93rem;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-family: inherit;
}
.form-control::placeholder { color: var(--adm-muted); }
.form-control:focus { outline: none; border-color: var(--adm-grad-a); box-shadow: 0 0 0 3px rgba(124,58,237,0.12); }
textarea.form-control { resize: vertical; min-height: 100px; }

.modal-actions { display: flex; justify-content: flex-end; gap: 12px; margin-top: 26px; }
.btn-cancel {
    background: var(--adm-hover);
    color: var(--adm-text);
    border: 1.5px solid var(--adm-border);
    padding: 11px 22px;
    border-radius: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel:hover { background: var(--adm-thead-bg); border-color: rgba(15,23,42,0.2); }
</style>
@endpush

@section('content')

<main class="dash">
  <div class="admin-body">
    
    <a href="{{ route('admin.applications.index', ['tab' => $tab, 'search' => $search, 'from_date' => $fromDate, 'to_date' => $toDate]) }}" class="back-link">
        <i data-lucide="arrow-left" style="width:16px;"></i> Back to Applications
    </a>

    <div class="glass-panel">
        <div class="header-top">
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <span style="font-size: 0.8rem; font-weight: 800; color: var(--adm-muted); text-transform: uppercase; letter-spacing: 1px;">Doctor Application Review</span>
                <h1>Application #{{ $application->id }}</h1>
            </div>
            <span class="badge {{ $application->status }}">{{ $application->status }}</span>
        </div>

        {{-- === SECTION 1: PERSONAL INFORMATION === --}}
        <span class="section-title">1. Personal Information</span>
        @php
            $bday = $application->user->bday ? \Carbon\Carbon::parse($application->user->bday) : null;
            $age   = $bday ? $bday->age : null;
            $genderMap = ['male' => 'Male', 'female' => 'Female', 'other' => 'Other', 'prefer_not_say' => 'Prefer not to say'];
        @endphp
        <div class="glass-card detail-grid">
            <div class="detail-item"><strong>First Name</strong><span>{{ $application->user->fname ?? '—' }}</span></div>
            <div class="detail-item"><strong>Middle Name</strong><span>{{ $application->user->mname ?? '—' }}</span></div>
            <div class="detail-item"><strong>Last Name</strong><span>{{ $application->user->lname ?? '—' }}</span></div>
            <div class="detail-item"><strong>Gender</strong><span>{{ $genderMap[$application->user->gender] ?? ucfirst($application->user->gender ?? '—') }}</span></div>
            <div class="detail-item"><strong>Birthday</strong><span>{{ $bday ? $bday->format('M d, Y') : '—' }}</span></div>
            <div class="detail-item"><strong>Age</strong><span>{{ $age !== null ? $age . ' years old' : '—' }}</span></div>
        </div>

        {{-- === SECTION 2: ACCOUNT CREDENTIALS === --}}
        <span class="section-title">2. Account Credentials</span>
        <div class="glass-card detail-grid">
            <div class="detail-item"><strong>Username</strong><span>{{ '@' . ($application->user->username ?? '—') }}</span></div>
            <div class="detail-item"><strong>Email Address</strong><span>{{ $application->user->email ?? '—' }}</span></div>
            <div class="detail-item"><strong>Account Role</strong><span style="text-transform: capitalize;">{{ $application->user->role ?? '—' }}</span></div>
            <div class="detail-item"><strong>Doctor Status</strong><span class="badge {{ $application->status }}">{{ ucfirst($application->status) }}</span></div>
        </div>

        {{-- === SECTION 3: PROFESSIONAL INFORMATION === --}}
        <span class="section-title">3. Professional Information</span>
        <div class="glass-card detail-grid">
            <div class="detail-item"><strong>Professional Title</strong><span>{{ $application->professional_titles ?? 'Not specified' }}</span></div>
            <div class="detail-item"><strong>Submitted On</strong><span>{{ $application->submitted_at->format('M d, Y') }}</span></div>
            <div class="detail-item"><strong>Time Submitted</strong><span>{{ $application->submitted_at->format('h:i A') }}</span></div>
        </div>

        {{-- === SECTION 4: BIOMETRIC VERIFICATION === --}}
        <span class="section-title">4. Biometric Verification</span>
        <div class="glass-card detail-grid">
            <div class="detail-item">
                <strong>Biometric Consent</strong>
                @if($application->biometric_consent)
                    <span style="color: #10b981;">✓ Agreed</span>
                @else
                    <span style="color: #ef4444;">✗ Not Given</span>
                @endif
            </div>
            <div class="detail-item">
                <strong>Liveness Verified</strong>
                @if($application->liveness_verified)
                    <span style="color: #10b981;">✓ Verified</span>
                @else
                    <span style="color: #ef4444;">✗ Not Verified</span>
                @endif
            </div>
            <div class="detail-item"><strong>Verified At</strong><span>{{ $application->biometric_verified_at ? \Carbon\Carbon::parse($application->biometric_verified_at)->format('M d, Y h:i A') : '—' }}</span></div>
        </div>

        {{-- === SECTION 5: SUBMITTED DOCUMENTS === --}}
        <span class="section-title">5. Submitted Documents</span>
        @php
            $submittedDocs = $application->documents->keyBy('doctor_requirement_id');
        @endphp

        @if(isset($requirements) && $requirements->isNotEmpty())
            <div class="document-list" style="margin-bottom: 40px;">
                @foreach($requirements as $req)
                    @php $doc = $submittedDocs->get($req->id); @endphp
                    <div class="document-item" style="{{ !$doc && $req->is_required ? 'border-left: 4px solid #ef4444;' : (!$doc ? 'border-left: 4px solid #f59e0b;' : 'border-left: 4px solid #10b981;') }}">
                        <div style="flex: 1; min-width: 200px;">
                            <div class="doc-name">
                                {{ $req->name }}
                                @if($req->is_required)
                                    <span style="background: rgba(239,68,68,0.1); color:#ef4444; padding: 2px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; margin-left: 8px;">Required</span>
                                @else
                                    <span style="background: rgba(255,255,255,0.05); color: var(--adm-muted); padding: 2px 8px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; margin-left: 8px;">Optional</span>
                                @endif
                            </div>
                            <div class="doc-desc">{{ $req->description ?? 'No description provided.' }}</div>

                            @if(!$doc)
                                <div style="margin-top: 12px; padding: 10px 16px; background: rgba(0,0,0,0.2); border: 1px solid {{ $req->is_required ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)' }}; border-radius: 8px; font-size: 0.85rem; color: {{ $req->is_required ? '#ef4444' : '#f59e0b' }};">
                                    <i data-lucide="alert-triangle" style="width:14px; margin-right:4px;"></i> 
                                    <strong>Not Submitted</strong> — {{ $req->is_required ? 'This required document is missing.' : 'This optional document was not provided.' }}
                                </div>
                            @else
                                @php
                                    $ext = $doc->file_path ? strtoupper(pathinfo($doc->file_path, PATHINFO_EXTENSION)) : null;
                                    $isVideo = in_array(strtolower($ext ?? ''), ['mp4', 'webm', 'mov', 'avi']);
                                @endphp
                                <div style="margin-top: 12px; display: flex; align-items: center; gap: 8px;">
                                    @if($ext)
                                        <span style="background: rgba(59,130,246,0.15); color:#3b82f6; padding: 4px 10px; border-radius: 6px; font-size:0.75rem; font-weight:800; border: 1px solid rgba(59,130,246,0.3);">
                                            {{ $isVideo ? '🎥' : '📄' }} {{ $ext }}
                                        </span>
                                    @endif
                                    <span style="font-size: 0.85rem; color: var(--adm-muted);">{{ basename($doc->file_path ?? '—') }}</span>
                                </div>
                            @endif
                        </div>

                        <div style="display: flex; align-items: center; gap: 16px; flex-shrink: 0; margin-left: 20px;">
                            @if($doc)
                                <span style="font-size: 0.85rem; color: {{ $doc->status === 'accepted' ? '#10b981' : ($doc->status === 'rejected' ? '#ef4444' : '#f59e0b') }}; font-weight: 700; text-transform: uppercase;">
                                    {{ $doc->status ?? 'submitted' }}
                                </span>
                                @if($doc->file_path)
                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn-outline">
                                        <i data-lucide="external-link" style="width: 14px;"></i> View File
                                    </a>
                                @endif
                            @else
                                <span style="font-size: 0.85rem; color: var(--adm-muted); font-style: italic;">No file attached</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: var(--adm-muted); padding: 30px; text-align: center; background: rgba(0,0,0,0.2); border-radius: 12px; font-weight: 600;">No requirement definitions found.</p>
        @endif

        {{-- === REVIEW ACTIONS === --}}
        @if($application->status === 'pending')
            <div class="action-bar">
                <button type="button" class="btn-solid btn-reject" onclick="openRejectModal()">
                    <i data-lucide="x-circle"></i> Reject Application
                </button>
                <button type="button" class="btn-solid btn-approve" onclick="openApproveModal()">
                    <i data-lucide="check-circle"></i> Approve & Verify
                </button>
            </div>
        @else
            <span class="section-title">Review History</span>
            <div class="notes-box" style="border-left-color: {{ $application->status === 'approved' ? '#10b981' : '#ef4444' }};">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:8px;">
                    <div class="notes-box-title">
                        @if($application->status === 'approved')
                            <i data-lucide="check-circle" style="width:16px;color:#10b981;"></i>
                        @else
                            <i data-lucide="x-circle" style="width:16px;color:#ef4444;"></i>
                        @endif
                        Administrator Feedback
                    </div>
                    <span class="notes-box-date">Reviewed on {{ $application->reviewed_at ? $application->reviewed_at->format('M d, Y h:i A') : '—' }}</span>
                </div>
                <div class="notes-box-body">{{ $application->admin_notes ?? 'No additional notes provided by the administrator.' }}</div>
            </div>
        @endif

    </div>
  </div>
</main>

<!-- Approve Modal -->
<div class="glass-modal-backdrop" id="approveModal">
    <div class="glass-modal" style="border-top: 4px solid #10b981;">
        <div class="modal-header">
            <h2>Approve Application</h2>
            <button class="modal-close" onclick="closeApproveModal()"><i data-lucide="x"></i></button>
        </div>
        <p style="color: var(--adm-text); font-size: 0.95rem; margin-bottom: 24px;">You are about to approve <strong>{{ $application->user->fname }} {{ $application->user->lname }}</strong> as a Verified Doctor. They will gain access to the Doctor Portal.</p>
        <form action="{{ route('admin.applications.approve', $application->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Admin Notes (Optional)</label>
                <textarea name="admin_notes" class="form-control" placeholder="Add approval notes or feedback for the doctor..."></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeApproveModal()">Cancel</button>
                <button type="submit" class="btn-solid btn-approve">Confirm Approval</button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div class="glass-modal-backdrop" id="rejectModal">
    <div class="glass-modal" style="border-top: 4px solid #ef4444;">
        <div class="modal-header">
            <h2>Reject Application</h2>
            <button class="modal-close" onclick="closeRejectModal()"><i data-lucide="x"></i></button>
        </div>
        <p style="color: var(--adm-text); font-size: 0.95rem; margin-bottom: 24px;">You are rejecting the application for <strong>{{ $application->user->fname }} {{ $application->user->lname }}</strong>. Please provide a reason so they can correct it and reapply.</p>
        <form action="{{ route('admin.applications.reject', $application->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Reason for Rejection <span style="color:#ef4444;">*</span></label>
                <textarea name="admin_notes" class="form-control" placeholder="Explain what is missing or invalid..." required></textarea>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeRejectModal()">Cancel</button>
                <button type="submit" class="btn-solid btn-reject">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});

function openApproveModal() { document.getElementById('approveModal').classList.add('open'); }
function closeApproveModal() { document.getElementById('approveModal').classList.remove('open'); }

function openRejectModal() { document.getElementById('rejectModal').classList.add('open'); }
function closeRejectModal() { document.getElementById('rejectModal').classList.remove('open'); }
</script>
@endpush
@endsection
