@extends('layouts.admin')

@section('title', 'Admin – My Profile')

@push('styles')
<style>
/* ── Admin Profile Page ─────────────────────────────────────── */
@keyframes floatIn {
  0%   { opacity: 0; transform: translateY(16px); }
  100% { opacity: 1; transform: translateY(0); }
}

.profile-shell {
  padding: 40px 24px 80px;
  min-height: 100vh;
  background: var(--adm-bg);
}

.profile-inner {
  max-width: 820px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
  gap: 24px;
  animation: floatIn 0.5s cubic-bezier(0.16,1,0.3,1) both;
}

/* Page heading */
.profile-heading {
  display: flex;
  align-items: center;
  gap: 14px;
  margin-bottom: 4px;
}
.profile-heading-icon {
  width: 44px;
  height: 44px;
  background: linear-gradient(135deg, var(--adm-header-from), var(--adm-header-to));
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(124,58,237,0.3);
}
.profile-heading-icon svg { width: 20px; height: 20px; color: #fff; }
.profile-heading h1 { font-size: 1.6rem; font-weight: 800; color: var(--adm-text); margin: 0; letter-spacing: -0.3px; }
.profile-heading p  { font-size: 0.88rem; color: var(--adm-muted); margin: 2px 0 0; }

/* Card base */
.prof-card {
  background: var(--adm-panel);
  border: 1px solid var(--adm-border);
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(15,23,42,0.06);
  overflow: hidden;
}
.prof-card-header {
  padding: 18px 24px 16px;
  border-bottom: 1px solid var(--adm-border);
  display: flex;
  align-items: center;
  gap: 10px;
}
.prof-card-header svg { width: 17px; height: 17px; color: var(--adm-grad-a); flex-shrink: 0; }
.prof-card-header h2 { font-size: 0.95rem; font-weight: 700; color: var(--adm-text); margin: 0; }
.prof-card-body { padding: 24px; }

/* Photo section */
.photo-row {
  display: flex;
  align-items: center;
  gap: 24px;
  flex-wrap: wrap;
}
.photo-avatar {
  position: relative;
  flex-shrink: 0;
}
.photo-avatar img {
  width: 100px;
  height: 100px;
  border-radius: 18px;
  object-fit: cover;
  border: 3px solid var(--adm-border);
  box-shadow: 0 4px 14px rgba(15,23,42,0.1);
  display: block;
}
.photo-info h3 { font-size: 1.05rem; font-weight: 700; color: var(--adm-text); margin: 0 0 4px; }
.photo-info p  { font-size: 0.83rem; color: var(--adm-muted); margin: 0 0 16px; }
.photo-actions { display: flex; gap: 10px; flex-wrap: wrap; }

.btn-photo {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  padding: 9px 16px;
  border-radius: 10px;
  font-size: 0.84rem;
  font-weight: 700;
  cursor: pointer;
  border: 1.5px solid var(--adm-border);
  background: var(--adm-hover);
  color: var(--adm-text);
  transition: all 0.2s;
  text-decoration: none;
}
.btn-photo:hover { background: var(--adm-thead-bg); border-color: rgba(15,23,42,0.2); }
.btn-photo svg  { width: 15px; height: 15px; }

.btn-photo-danger {
  border-color: rgba(239,68,68,0.35);
  background: rgba(239,68,68,0.05);
  color: #dc2626;
}
.btn-photo-danger:hover { background: rgba(239,68,68,0.1); border-color: rgba(239,68,68,0.5); }

.btn-photo-save {
  border-color: rgba(124,58,237,0.35);
  background: rgba(124,58,237,0.08);
  color: var(--adm-grad-a);
  display: none;
}
.btn-photo-save:hover { background: rgba(124,58,237,0.14); border-color: rgba(124,58,237,0.5); }

.photo-filename {
  font-size: 0.8rem;
  color: var(--adm-grad-a);
  margin-top: 8px;
  font-weight: 600;
  display: none;
}

/* Form fields */
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 18px;
}
.form-grid.full { grid-template-columns: 1fr; }
@media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }

.form-group { display: flex; flex-direction: column; gap: 6px; }
.form-group label {
  font-size: 0.8rem;
  font-weight: 700;
  color: var(--adm-muted);
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.form-control {
  width: 100%;
  padding: 11px 14px;
  border-radius: 10px;
  border: 1.5px solid var(--adm-border);
  background: var(--adm-input-bg);
  color: var(--adm-text);
  font-size: 0.93rem;
  font-family: inherit;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control::placeholder { color: var(--adm-muted); opacity: 0.7; }
.form-control:focus {
  border-color: var(--adm-grad-a);
  outline: none;
  box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
}
select.form-control { cursor: pointer; }

/* Save button */
.btn-save {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 11px 26px;
  border-radius: 12px;
  border: none;
  background: linear-gradient(135deg, var(--adm-header-from), var(--adm-header-to));
  color: #fff;
  font-size: 0.93rem;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 4px 14px rgba(124,58,237,0.3);
  transition: all 0.2s;
}
.btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(124,58,237,0.38); }
.btn-save svg   { width: 16px; height: 16px; }

/* Alerts */
.alert {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 13px 16px;
  border-radius: 12px;
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 0;
}
.alert svg { width: 16px; height: 16px; flex-shrink: 0; }
.alert-success { background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.3); }
.alert-error   { background: rgba(239,68,68,0.08);  color: #dc2626; border: 1px solid rgba(239,68,68,0.25); }
</style>
@endpush

@section('content')
<main class="dash">
<div class="profile-shell">
<div class="profile-inner">

  {{-- Page heading --}}
  <div class="profile-heading">
    <div class="profile-heading-icon">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
      </svg>
    </div>
    <div>
      <h1>My Profile</h1>
      <p>Manage your admin account information</p>
    </div>
  </div>

  {{-- Flash messages --}}
  @if(session('success'))
    <div class="alert alert-success">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="alert alert-error">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      {{ session('error') }}
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-error" style="flex-direction:column;align-items:flex-start;gap:4px;">
      @foreach($errors->all() as $err)
        <span>• {{ $err }}</span>
      @endforeach
    </div>
  @endif

  {{-- ── Profile Photo Card ──────────────────────────────────── --}}
  <div class="prof-card">
    <div class="prof-card-header">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
      <h2>Profile Photo</h2>
    </div>
    <div class="prof-card-body">
      <div class="photo-row">
        <div class="photo-avatar">
          <img src="{{ $avatarUrl }}" alt="Admin Avatar" id="avatarPreview">
        </div>
        <div class="photo-info">
          <h3>{{ $admin->fname }} {{ $admin->lname }}</h3>
          <p>Administrator · PNG, JPG or GIF — max 2 MB</p>
          <div class="photo-actions">
            <form action="{{ route('admin.profile.update.photo') }}" method="POST"
                  enctype="multipart/form-data" id="photoUploadForm" style="margin:0;display:contents;">
              @csrf
              <input type="file" name="profile_photo" id="profile_photo"
                     accept="image/png,image/jpeg,image/gif" style="display:none;">
              <button type="button" class="btn-photo" id="choosePhotoBtn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Upload Photo
              </button>
              <button type="submit" class="btn-photo btn-photo-save" id="uploadPhotoBtn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                Save Photo
              </button>
            </form>
            @if($admin->avatar_url)
            <form action="{{ route('admin.profile.delete.photo') }}" method="POST" style="margin:0;">
              @csrf
              <button type="submit" class="btn-photo btn-photo-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                Remove
              </button>
            </form>
            @endif
          </div>
          <div class="photo-filename" id="photoFilename"></div>
        </div>
      </div>
    </div>
  </div>

  {{-- ── Personal Information Card ──────────────────────────── --}}
  <div class="prof-card">
    <div class="prof-card-header">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <h2>Personal Information</h2>
    </div>
    <div class="prof-card-body">
      <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf

        {{-- Name row --}}
        <div class="form-grid" style="margin-bottom:18px;">
          <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" class="form-control"
                   value="{{ old('fname', $admin->fname) }}" placeholder="First name" required>
          </div>
          <div class="form-group">
            <label for="mname">Middle Name</label>
            <input type="text" id="mname" name="mname" class="form-control"
                   value="{{ old('mname', $admin->mname) }}" placeholder="Middle name (optional)">
          </div>
        </div>

        <div class="form-grid full" style="margin-bottom:18px;">
          <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" class="form-control"
                   value="{{ old('lname', $admin->lname) }}" placeholder="Last name" required>
          </div>
        </div>

        {{-- Email --}}
        <div class="form-grid full" style="margin-bottom:18px;">
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control"
                   value="{{ old('email', $admin->email) }}" placeholder="admin@example.com" required>
          </div>
        </div>

        {{-- Gender + Birthday --}}
        <div class="form-grid" style="margin-bottom:26px;">
          <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" class="form-control">
              <option value="">Select gender</option>
              <option value="male"   {{ old('gender', $admin->gender) === 'male'   ? 'selected' : '' }}>Male</option>
              <option value="female" {{ old('gender', $admin->gender) === 'female' ? 'selected' : '' }}>Female</option>
              <option value="other"  {{ old('gender', $admin->gender) === 'other'  ? 'selected' : '' }}>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label for="bday">Birthday</label>
            <input type="date" id="bday" name="bday" class="form-control"
                   value="{{ old('bday', $admin->bday ? $admin->bday->format('Y-m-d') : '') }}">
          </div>
        </div>

        <div style="display:flex;justify-content:flex-end;">
          <button type="submit" class="btn-save">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- ── Account Info (read-only) ──────────────────────────── --}}
  <div class="prof-card">
    <div class="prof-card-header">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      <h2>Account Details</h2>
    </div>
    <div class="prof-card-body">
      <div class="form-grid">
        <div class="form-group">
          <label>Role</label>
          <div class="form-control" style="cursor:default;display:flex;align-items:center;gap:8px;">
            <span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#7c3aed;flex-shrink:0;"></span>
            Administrator
          </div>
        </div>
        <div class="form-group">
          <label>Member Since</label>
          <div class="form-control" style="cursor:default;">
            {{ $admin->created_at ? $admin->created_at->format('M d, Y') : '—' }}
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  if (typeof lucide !== 'undefined') lucide.createIcons();

  const fileInput    = document.getElementById('profile_photo');
  const chooseBtn    = document.getElementById('choosePhotoBtn');
  const uploadBtn    = document.getElementById('uploadPhotoBtn');
  const fileNameDiv  = document.getElementById('photoFilename');
  const avatarImg    = document.getElementById('avatarPreview');

  if (chooseBtn) {
    chooseBtn.addEventListener('click', () => fileInput.click());
  }

  if (fileInput) {
    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (!file) return;

      // Show save button + filename label
      uploadBtn.style.display = 'inline-flex';
      fileNameDiv.style.display = 'block';
      fileNameDiv.textContent = '📎 ' + file.name;

      // Live preview
      const reader = new FileReader();
      reader.onload = e => { avatarImg.src = e.target.result; };
      reader.readAsDataURL(file);
    });
  }
});
</script>
@endpush
@endsection
