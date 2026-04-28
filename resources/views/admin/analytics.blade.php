@extends('layouts.admin')

@section('title', 'Admin – Platform Analytics')

@push('styles')
<style>
/* ── Admin Analytics – Light Mode ──────────────────────────── */
@keyframes floatIn {
    0%   { opacity: 0; transform: translateY(18px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes growWidth { 0% { width: 0; } }
@keyframes shimmer  {
    0%   { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.admin-body {
    padding: 40px 24px;
    min-height: 100vh;
    background: var(--adm-bg);
}

/* ── Filter bar ─────────────────────────────────────────────── */
.filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    padding: 22px 28px;
    background: var(--adm-panel);
    border: 1px solid var(--adm-border);
    border-radius: 20px;
    box-shadow: var(--adm-shadow-sm);
    margin-bottom: 28px;
    animation: floatIn 0.45s cubic-bezier(0.16,1,0.3,1) both;
}

.filter-title {
    display: flex;
    align-items: center;
    gap: 14px;
    font-weight: 800;
    font-size: 1.4rem;
    color: var(--adm-text);
    letter-spacing: -0.3px;
}
.filter-title-icon {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #3b82f6, #2dd4bf);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(59,130,246,0.3);
}
.filter-title-icon i { width: 22px; height: 22px; color: #fff; }

.filter-form { display: flex; gap: 14px; align-items: flex-end; flex-wrap: wrap; }

.input-group  { display: flex; flex-direction: column; gap: 5px; }
.input-group label {
    font-size: 0.72rem;
    font-weight: 800;
    color: var(--adm-muted);
    text-transform: uppercase;
    letter-spacing: 1px;
}
.input-group input {
    background: var(--adm-input-bg);
    border: 1.5px solid var(--border);
    padding: 10px 14px;
    border-radius: 10px;
    color: var(--adm-text);
    font-size: 0.9rem;
    font-family: inherit;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.input-group input:focus {
    outline: none;
    border-color: var(--adm-grad-a);
    box-shadow: 0 0 0 3px rgba(124,58,237,0.14);
}

.clear-btn {
    color: var(--adm-muted);
    text-decoration: none;
    padding: 10px 14px;
    font-size: 0.88rem;
    font-weight: 600;
    border-radius: 10px;
    transition: color 0.2s, background 0.2s;
}
.clear-btn:hover { color: var(--adm-text); background: var(--adm-hover); }

/* ── KPI grid ───────────────────────────────────────────────── */
.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 28px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 22px 24px;
    background: var(--adm-panel);
    border: 1px solid var(--adm-border);
    border-radius: 20px;
    box-shadow: var(--adm-shadow-row);
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
    animation: floatIn 0.5s cubic-bezier(0.16,1,0.3,1) both;
    opacity: 0;
}
.stat-card:nth-child(1) { animation-delay: 0.08s; }
.stat-card:nth-child(2) { animation-delay: 0.16s; }
.stat-card:nth-child(3) { animation-delay: 0.24s; }
.stat-card:nth-child(4) { animation-delay: 0.32s; }

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(15,23,42,0.1);
    border-color: rgba(124,58,237,0.2);
}

/* Glowing icon badge */
.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}
.stat-icon::before {
    content: '';
    position: absolute;
    inset: -3px;
    border-radius: 17px;
    background: inherit;
    filter: blur(10px);
    opacity: 0.35;
    z-index: -1;
    transition: opacity 0.25s;
}
.stat-card:hover .stat-icon::before { opacity: 0.55; }
.stat-icon i { width: 26px; height: 26px; color: #fff; }

.stat-info { display: flex; flex-direction: column; }
.stat-value {
    font-size: 2rem;
    font-weight: 900;
    color: var(--adm-text);
    line-height: 1.1;
}
.stat-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--adm-muted);
    text-transform: uppercase;
    letter-spacing: 0.8px;
    margin-top: 4px;
}

/* Icon gradients (same vibrant colors, unchanged) */
.stat-total    .stat-icon { background: linear-gradient(135deg, #3b82f6, #2dd4bf); }
.stat-approved .stat-icon { background: linear-gradient(135deg, #10b981, #a3e635); }
.stat-pending  .stat-icon { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
.stat-psych    .stat-icon { background: linear-gradient(135deg, #8b5cf6, #ec4899); }

/* ── Section cards ──────────────────────────────────────────── */
.analytics-sections {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
    gap: 24px;
    animation: floatIn 0.55s cubic-bezier(0.16,1,0.3,1) 0.4s both;
    opacity: 0;
}

.section-card {
    background: var(--adm-panel);
    border: 1px solid var(--adm-border);
    border-radius: 20px;
    padding: 26px;
    box-shadow: var(--adm-shadow-row);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--adm-border-2);
}
.card-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: var(--adm-text);
    letter-spacing: -0.2px;
}
.card-icon-badge {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.card-icon-badge i { width: 18px; height: 18px; }

/* Progress bars */
.progress-wrap { margin-bottom: 20px; }
.data-row {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 8px;
}
.data-label {
    font-weight: 600;
    font-size: 0.9rem;
    color: var(--adm-text);
}
.data-value {
    font-weight: 800;
    font-size: 1rem;
    color: var(--adm-text);
}
.data-sub {
    font-size: 0.75rem;
    color: var(--adm-muted);
    font-weight: 600;
    margin-left: 4px;
}

.progress-bar-container {
    width: 100%;
    height: 8px;
    background: var(--adm-hover);
    border-radius: 99px;
    overflow: hidden;
}
.progress-bar {
    height: 100%;
    border-radius: 99px;
    position: relative;
    animation: growWidth 1.4s cubic-bezier(0.2,0.8,0.2,1) forwards;
}
.progress-bar::after {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.45) 50%, rgba(255,255,255,0) 100%);
    animation: shimmer 2s infinite linear;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: var(--adm-muted);
    font-weight: 600;
    font-size: 0.9rem;
}
</style>
@endpush

@section('content')
<main class="dash">
  <div class="admin-body">

    {{-- ── Filter Bar ────────────────────────────────────────── --}}
    <div class="filter-bar">
      <div class="filter-title">
        <div class="filter-title-icon">
          <i data-lucide="bar-chart-3"></i>
        </div>
        Platform Analytics
      </div>
      <form action="{{ route('admin.analytics') }}" method="GET" class="filter-form">
        <div class="input-group">
          <label>From Date</label>
          <input type="date" name="from_date" value="{{ $fromDate ?? '' }}" onchange="this.form.submit()">
        </div>
        <div class="input-group">
          <label>To Date</label>
          <input type="date" name="to_date" value="{{ $toDate ?? '' }}" onchange="this.form.submit()">
        </div>
        @if($fromDate || $toDate)
          <a href="{{ route('admin.analytics') }}" class="clear-btn">Clear</a>
        @endif
      </form>
    </div>

    {{-- ── KPI Cards ─────────────────────────────────────────── --}}
    <div class="analytics-grid">
      <div class="stat-card stat-total">
        <div class="stat-icon"><i data-lucide="file-text"></i></div>
        <div class="stat-info">
          <span class="stat-value">{{ number_format($stats['total']) }}</span>
          <span class="stat-label">Total Submissions</span>
        </div>
      </div>

      <div class="stat-card stat-approved">
        <div class="stat-icon"><i data-lucide="check-circle"></i></div>
        <div class="stat-info">
          <span class="stat-value">{{ number_format($stats['approved']) }}</span>
          <span class="stat-label">Approved Doctors</span>
        </div>
      </div>

      <div class="stat-card stat-pending">
        <div class="stat-icon"><i data-lucide="clock"></i></div>
        <div class="stat-info">
          <span class="stat-value">{{ number_format($stats['pending']) }}</span>
          <span class="stat-label">Pending Review</span>
        </div>
      </div>

      <div class="stat-card stat-psych">
        <div class="stat-icon"><i data-lucide="brain"></i></div>
        <div class="stat-info">
          <span class="stat-value">{{ number_format($stats['psych']) }}</span>
          <span class="stat-label">Psych Specialists</span>
        </div>
      </div>
    </div>

    {{-- ── Detail Sections ───────────────────────────────────── --}}
    <div class="analytics-sections">

      {{-- Top Professional Titles --}}
      <div class="section-card">
        <div class="card-header">
          <div class="card-title">Top Professional Titles</div>
          <div class="card-icon-badge" style="background: rgba(139,92,246,0.1);">
            <i data-lucide="briefcase" style="color:#7c3aed;"></i>
          </div>
        </div>
        @if(count($specialties) === 0)
          <div class="empty-state">No data available for this period.</div>
        @endif
        @foreach($specialties as $index => $s)
          @php
            $percent = $stats['total'] > 0 ? ($s->count / $stats['total']) * 100 : 0;
            $colors = [
              'linear-gradient(90deg, #8b5cf6, #d946ef)',
              'linear-gradient(90deg, #3b82f6, #2dd4bf)',
              'linear-gradient(90deg, #f59e0b, #fbbf24)',
              'linear-gradient(90deg, #10b981, #34d399)',
              'linear-gradient(90deg, #ec4899, #f43f5e)',
            ];
            $bg = $colors[$index % count($colors)];
          @endphp
          <div class="progress-wrap">
            <div class="data-row">
              <span class="data-label">{{ $s->professional_titles ?: 'Not Specified' }}</span>
              <span class="data-value" style="background: {{ $bg }}; -webkit-background-clip: text; color: transparent;">
                {{ $s->count }}
              </span>
            </div>
            <div class="progress-bar-container">
              <div class="progress-bar" style="width: {{ $percent }}%; background: {{ $bg }};"></div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Gender Distribution --}}
      <div class="section-card">
        <div class="card-header">
          <div class="card-title">Gender Distribution</div>
          <div class="card-icon-badge" style="background: rgba(236,72,153,0.1);">
            <i data-lucide="users" style="color:#ec4899;"></i>
          </div>
        </div>
        @if(count($genderData) === 0)
          <div class="empty-state">No demographic data available.</div>
        @endif
        @foreach($genderData as $g)
          @php
            $percent = $stats['total'] > 0 ? ($g['count'] / $stats['total']) * 100 : 0;
            $bg = $g['label'] === 'Male'
              ? 'linear-gradient(90deg, #3b82f6, #60a5fa)'
              : ($g['label'] === 'Female'
                ? 'linear-gradient(90deg, #ec4899, #f472b6)'
                : 'linear-gradient(90deg, #8b5cf6, #a78bfa)');
          @endphp
          <div class="progress-wrap">
            <div class="data-row">
              <span class="data-label">{{ $g['label'] }}</span>
              <span class="data-value">
                {{ $g['count'] }}<span class="data-sub">APPLICANTS</span>
              </span>
            </div>
            <div class="progress-bar-container">
              <div class="progress-bar" style="width: {{ $percent }}%; background: {{ $bg }};"></div>
            </div>
          </div>
        @endforeach
      </div>

    </div>{{-- /.analytics-sections --}}

  </div>
</main>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>
@endpush
