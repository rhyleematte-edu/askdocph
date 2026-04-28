@extends('layouts.admin')
@section('title', 'Admin – Doctor Applications')

@push('styles')
<style>
@keyframes floatIn { 0% { opacity:0; transform:translateY(16px); } 100% { opacity:1; transform:translateY(0); } }

.apps-page  { max-width: 1100px; margin: 0 auto; }
.apps-panel { animation: floatIn 0.45s cubic-bezier(0.16,1,0.3,1) both; }

/* ── Filter widget ──────────────────────────────────────────── */
.filter-card {
  background: var(--adm-panel);
  border: 1px solid var(--adm-border);
  border-radius: 16px;
  padding: 20px 22px;
  box-shadow: var(--adm-shadow);
  margin-bottom: 18px;
  animation: floatIn 0.45s cubic-bezier(0.16,1,0.3,1) 0.05s both;
  transition: background 0.3s, border-color 0.3s;
}
.filter-form {
  display: flex; gap: 16px; flex-wrap: wrap; align-items: flex-end;
}
.filter-search-box {
  flex: 1; min-width: 260px; position: relative;
}
.filter-search-box i {
  position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
  color: var(--adm-muted); width: 17px; height: 17px; pointer-events: none;
  transition: color 0.2s;
}
.filter-search-box input {
  width: 100%; padding: 11px 14px 11px 40px;
  border-radius: 11px; border: 1.5px solid var(--adm-border);
  background: var(--adm-input-bg); color: var(--adm-text);
  font-size: 0.92rem; font-family: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}
.filter-search-box input::placeholder { color: var(--adm-muted); opacity: 0.7; }
.filter-search-box input:focus {
  border-color: var(--adm-grad-a); outline: none;
  box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
  background: var(--adm-input-focus);
}

.date-filters { display: flex; gap: 14px; }
.date-grp     { display: flex; flex-direction: column; gap: 5px; }
.date-grp label {
  font-size: 0.7rem; font-weight: 800; color: var(--adm-muted);
  text-transform: uppercase; letter-spacing: 1px;
}
.date-grp input[type="date"] {
  background: var(--adm-input-bg); border: 1.5px solid var(--adm-border);
  padding: 10px 13px; border-radius: 11px; color: var(--adm-text);
  font-size: 0.88rem; font-family: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}
.date-grp input[type="date"]:focus {
  border-color: var(--adm-grad-a); outline: none;
  box-shadow: 0 0 0 3px rgba(124,58,237,0.12);
  background: var(--adm-input-focus);
}

/* ── Tabs ───────────────────────────────────────────────────── */
.app-tabs { display: flex; gap: 7px; flex-wrap: wrap; margin-bottom: 16px; }
.app-tabs a {
  text-decoration: none; color: var(--adm-muted); font-weight: 600;
  padding: 8px 16px; border-radius: 9px; font-size: 0.86rem;
  background: var(--adm-panel); border: 1.5px solid var(--adm-border);
  transition: all 0.2s;
}
.app-tabs a:hover { background: var(--adm-hover); color: var(--adm-grad-a); border-color: rgba(124,58,237,0.3); }
.app-tabs a.active {
  background: linear-gradient(135deg, rgba(124,58,237,0.12), rgba(79,70,229,0.08));
  color: var(--adm-grad-a); border-color: rgba(124,58,237,0.38); font-weight: 800;
  box-shadow: 0 2px 8px rgba(124,58,237,0.1);
}

/* ── Table footer ───────────────────────────────────────────── */
.table-footer {
  padding: 16px 22px; color: var(--adm-muted);
  font-size: 0.85rem; font-weight: 600;
  border-top: 1px solid var(--adm-border-2);
}
</style>
@endpush

@section('content')
<main class="dash">
<div class="adm-page">
<div class="apps-page">

  {{-- Page title --}}
  <h1 style="font-size:1.7rem;font-weight:800;margin:0 0 20px;color:var(--adm-text);letter-spacing:-0.3px;">
    Doctor Applications Overview
  </h1>

  {{-- Filter card --}}
  <div class="filter-card">
    <form action="{{ route('admin.applications.index') }}" method="GET" class="filter-form">
      <input type="hidden" name="tab" value="{{ $tab }}">

      <div class="filter-search-box">
        <i data-lucide="search"></i>
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="Search by name or email…" autocomplete="off">
      </div>

      <div class="date-filters">
        <div class="date-grp">
          <label>From Date</label>
          <input type="date" name="from_date" value="{{ $fromDate ?? '' }}" onchange="this.form.submit()">
        </div>
        <div class="date-grp">
          <label>To Date</label>
          <input type="date" name="to_date" value="{{ $toDate ?? '' }}" onchange="this.form.submit()">
        </div>
      </div>
    </form>
  </div>

  {{-- Status tabs --}}
  <div class="app-tabs">
    @foreach(['all' => 'All', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
      @php $count = $counts[$key] ?? 0; @endphp
      <a href="{{ route('admin.applications.index', ['tab' => $key, 'search' => $search ?? '', 'from_date' => $fromDate ?? '', 'to_date' => $toDate ?? '']) }}"
         class="{{ $tab === $key ? 'active' : '' }}">
        {{ $label }} @if($count > 0)<span style="opacity:0.65;">({{ $count }})</span>@endif
      </a>
    @endforeach
  </div>

  {{-- Table card --}}
  <div class="adm-card apps-panel">
    <div class="adm-table-wrap">
      <table class="adm-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Submitted At</th>
            <th style="text-align:right;">Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($applications as $app)
            <tr>
              <td style="color:var(--adm-muted);font-weight:700;">#{{ $app->id }}</td>
              <td style="font-weight:600;">{{ $app->user->name ?? '—' }}</td>
              <td style="color:var(--adm-muted);">{{ $app->user->email ?? '—' }}</td>
              <td>
                <span class="badge {{ strtolower($app->status) }}">
                  {{ ucfirst($app->status) }}
                </span>
              </td>
              <td style="color:var(--adm-muted);font-size:0.84rem;">
                {{ $app->created_at->format('h:i A') }}<br>
                <span style="font-size:0.78rem;opacity:0.7;">{{ $app->created_at->format('M d, Y') }}</span>
              </td>
              <td style="text-align:right;">
                <a href="{{ route('admin.applications.show', ['id' => $app->id, 'tab' => $tab]) }}"
                   class="btn-view">
                  <i data-lucide="eye" style="width:13px;"></i> View Details
                </a>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="adm-empty">No applications found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="table-footer">Showing {{ $applications->count() }} application{{ $applications->count() !== 1 ? 's' : '' }}</div>
  </div>

</div>
</div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
</script>
@endpush
