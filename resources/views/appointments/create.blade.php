@extends('layouts.dashboard')

@section('title', 'Create Appointment | AskDocPH')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/appointments_ios.css') }}">
    <!-- Trendy Pickers (Flatpickr) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <style>
        @keyframes floatInCreate {
            0% { opacity: 0; transform: translateY(24px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .creation-page-wrapper {
            padding-top: 88px;
            background: linear-gradient(135deg, #0a0f1d 0%, #0f172a 50%, #1a0a2e 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Ambient background orbs */
        .creation-page-wrapper::before {
            content: '';
            position: fixed;
            top: -200px; right: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        .creation-page-wrapper::after {
            content: '';
            position: fixed;
            bottom: -200px; left: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        .apt-view-container {
            height: auto !important;
            min-height: calc(100vh - 88px);
            position: relative;
            z-index: 1;
        }

        /* ── Layout ── */
        .create-body {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 28px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 24px 60px;
            align-items: start;
        }

        /* ── Main Column ── */
        .create-main {
            animation: floatInCreate 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .discard-draft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: rgba(255,255,255,0.5);
            font-size: 0.78rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            margin-bottom: 28px;
            padding: 8px 16px;
            border-radius: 20px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            transition: all 0.2s;
        }
        .discard-draft:hover {
            color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
        }
        .discard-draft i { width: 14px; height: 14px; }

        /* ── Title Area ── */
        .title-section { margin-bottom: 36px; }

        .massive-title-input {
            width: 100%;
            background: transparent;
            border: none;
            outline: none;
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 900;
            color: #fff;
            resize: none;
            line-height: 1.15;
            letter-spacing: -1px;
            caret-color: #8b5cf6;
            overflow: hidden;
        }
        .massive-title-input::placeholder { color: rgba(255,255,255,0.2); }

        .title-underline {
            height: 2px;
            margin-top: 10px;
            background: linear-gradient(90deg, #8b5cf6, #3b82f6, transparent);
            border-radius: 2px;
        }

        /* ── Section Label ── */
        .section-label {
            font-size: 0.7rem;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-bottom: 10px;
            display: block;
        }

        /* ── Hero Pills (Date/Time) ── */
        .hero-inputs-grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 28px;
        }

        .hero-pill-wrap { display: flex; flex-direction: column; }

        .hero-pill {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 20px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .hero-pill:hover {
            background: rgba(255,255,255,0.08);
            border-color: rgba(139, 92, 246, 0.4);
            transform: translateX(4px);
        }

        .pill-icon-red {
            width: 22px; height: 22px;
            color: #ef4444;
            flex-shrink: 0;
        }

        .hero-pill-value {
            font-size: 1.15rem;
            font-weight: 700;
            color: #fff;
        }

        .selection-suite-ios {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1), padding 0.3s;
            background: rgba(0,0,0,0.3);
            border-radius: 0 0 16px 16px;
            border: 0 solid rgba(255,255,255,0.08);
        }
        .selection-suite-ios.expanded {
            max-height: 400px;
            padding: 12px;
            border-width: 0 1px 1px 1px;
        }

        /* ── Location Pill ── */
        .location-pill-wrap { margin-bottom: 28px; }

        .hero-pill-input {
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
        }
        .hero-pill-input::placeholder { color: rgba(255,255,255,0.3); }

        /* ── Studio Visual (Cover Image) ── */
        .visual-placeholder-ios {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            margin-bottom: 28px;
            border: 2px dashed rgba(139, 92, 246, 0.3);
            transition: all 0.3s;
        }
        .visual-placeholder-ios:hover {
            border-color: rgba(139, 92, 246, 0.6);
            transform: scale(1.005);
        }

        .ios-visual-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .visual-placeholder-ios:hover .ios-visual-img { opacity: 0.5; }

        .visual-edit-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            gap: 8px;
            opacity: 0;
            transition: opacity 0.3s;
            backdrop-filter: blur(4px);
        }
        .visual-placeholder-ios:hover .visual-edit-overlay { opacity: 1; }
        .visual-edit-overlay .overlay-title {
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 1px;
        }
        .visual-edit-overlay .overlay-sub {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.7);
        }

        /* ── Editorial Notes ── */
        .editorial-textarea-ios {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px;
            padding: 18px 20px;
            color: #fff;
            font-size: 0.95rem;
            font-family: inherit;
            outline: none;
            resize: vertical;
            min-height: 120px;
            transition: all 0.3s;
            line-height: 1.6;
            margin-top: 10px;
        }
        .editorial-textarea-ios::placeholder { color: rgba(255,255,255,0.3); }
        .editorial-textarea-ios:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.2);
            background: rgba(255,255,255,0.07);
        }

        /* ── Right Sidebar ── */
        .create-sidebar {
            display: flex;
            flex-direction: column;
            gap: 20px;
            position: sticky;
            top: 100px;
            animation: floatInCreate 0.5s 0.15s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        /* Action Card */
        .action-card-ios {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 24px;
        }

        .btn-create-apt-red {
            width: 100%;
            padding: 15px 20px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 14px;
            font-size: 1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            letter-spacing: 0.3px;
        }
        .btn-create-apt-red:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(239, 68, 68, 0.5);
        }

        .workspace-label-mini {
            margin-top: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.3);
            text-align: center;
        }

        /* Participants Section */
        .participants-section-ios {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 24px;
        }

        .sidebar-header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .ios-btn-link-red {
            font-size: 0.8rem;
            font-weight: 800;
            color: #ef4444;
            cursor: pointer;
            padding: 6px 12px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 8px;
            border: 1px solid rgba(239, 68, 68, 0.2);
            transition: all 0.2s;
        }
        .ios-btn-link-red:hover {
            background: rgba(239, 68, 68, 0.2);
        }

        .ios-search-minimal {
            width: 100%;
            background: rgba(0,0,0,0.2);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 12px 16px;
            color: #fff;
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: all 0.3s;
        }
        .ios-search-minimal::placeholder { color: rgba(255,255,255,0.3); }
        .ios-search-minimal:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background: rgba(0,0,0,0.3);
        }

        .search-dropdown-ios {
            position: absolute;
            z-index: 100;
            left: 0; right: 0;
            top: 100%;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            margin-top: 8px;
            overflow: hidden;
        }

        /* Error / Conflict boxes */
        .ios-error-box {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            display: none;
        }

        .ios-conflict-alert-v2 {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #f59e0b;
            padding: 14px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 600;
            display: none;
        }

        .participants-stack {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .create-body { grid-template-columns: 1fr; padding: 20px 16px 60px; }
            .create-sidebar { position: static; }
        }
    </style>
@endpush

@section('content')
    <div class="creation-page-wrapper">
        <!-- Premium Highlight Orbs -->
        <div class="highlight-orb orb-red"></div>
        <div class="highlight-orb orb-purple"></div>

        <div id="aptViewCreate" class="apt-view-container">
            <div class="create-body">
                <!-- Left: Main Form -->
                <div class="create-main">
                    <div class="discard-draft" onclick="window.history.back()">
                        <i data-lucide="chevron-left"></i> DISCARD DRAFT
                    </div>

                    <div class="title-section">
                        <textarea id="aptSubject" class="massive-title-input" placeholder="Appointment Title" required
                            autofocus rows="1"></textarea>
                        <div class="title-underline"></div>
                    </div>

                    <div class="hero-inputs-grid">
                        <div class="hero-pill-wrap">
                            <label class="section-label">DATE</label>
                            <div class="hero-pill" onclick="toggleSuite('dateSuite')">
                                <i data-lucide="calendar" class="pill-icon-red"></i>
                                <div class="hero-pill-content">
                                    <div id="displayAptDate" class="hero-pill-value">October 24, 2024</div>
                                </div>
                            </div>
                            <div id="dateSuite" class="selection-suite-ios">
                                <input type="text" id="dateInput" style="display:none;" required>
                            </div>
                        </div>

                        <div class="hero-pill-wrap">
                            <label class="section-label">START TIME</label>
                            <div class="hero-pill" onclick="toggleSuite('startSuite')">
                                <i data-lucide="clock" class="pill-icon-red"></i>
                                <div class="hero-pill-content">
                                    <span id="displayStartTime" class="hero-pill-value">10:00 AM</span>
                                </div>
                            </div>
                            <div id="startSuite" class="selection-suite-ios">
                                <input type="text" id="startTimeInput" style="display:none;">
                            </div>
                        </div>

                        <div class="hero-pill-wrap">
                            <label class="section-label">END TIME</label>
                            <div class="hero-pill" onclick="toggleSuite('endSuite')">
                                <i data-lucide="clock" class="pill-icon-red"></i>
                                <div class="hero-pill-content">
                                    <span id="displayEndTime" class="hero-pill-value">11:00 AM</span>
                                </div>
                            </div>
                            <div id="endSuite" class="selection-suite-ios">
                                <input type="text" id="endTimeInput" style="display:none;">
                            </div>
                        </div>
                    </div>

                    <!-- Final Submission Data (Hidden) -->
                    <input type="hidden" id="aptStart" required>
                    <input type="hidden" id="aptEnd" required>

                    <div class="hero-pill-wrap location-pill-wrap" style="margin-top: 1.5rem;">
                        <label class="section-label">LOCATION</label>
                        <div class="hero-pill">
                            <i data-lucide="map-pin" class="pill-icon-red"></i>
                            <input type="text" id="aptLocation" class="hero-pill-input"
                                placeholder="Add a studio or virtual link">
                        </div>
                    </div>

                    <div class="visual-placeholder-ios" onclick="document.getElementById('aptCoverInput').click()">
                        <img id="aptCoverPreview" src="{{ asset('assets/img/appointment_default.jpg') }}"
                            alt="Appointment Cover Photo" class="ios-visual-img">
                        <div class="visual-edit-overlay">
                            <i data-lucide="camera" style="width:28px;height:28px;"></i>
                            <span class="overlay-title">Change Cover Photo</span>
                            <span class="overlay-sub">Click to upload a custom image</span>
                        </div>
                    </div>
                    <input type="file" id="aptCoverInput" style="display:none;" accept="image/*">

                    <label class="section-label">EDITORIAL NOTES</label>
                    <textarea id="aptDescription" class="editorial-textarea-ios"
                        placeholder="Describe the creative intent or agenda..."></textarea>
                </div>

                <!-- Right: Sidebar -->
                <div class="create-sidebar">
                    <div class="action-card-ios">
                        <button type="button" id="btnSubmitApt" class="btn-create-apt-red">Create Appointment</button>
                        <div class="workspace-label-mini">WORKSPACE: EDITORIAL STUDIO</div>
                    </div>

                    <div class="participants-section-ios">
                        <div class="sidebar-header-row">
                            <label class="section-label">PARTICIPANTS</label>
                            <div class="ios-btn-link-red" onclick="document.getElementById('aptUserSearch').focus()">+ ADD
                                NEW</div>
                        </div>

                        <div id="aptSelectedUsers" class="participants-stack">
                            <!-- Selected participants will appear here dynamically -->
                        </div>

                        <div style="position:relative; margin-top: 1rem;">
                            <input type="text" id="aptUserSearch" class="ios-search-minimal" placeholder="Search users...">
                            <div id="aptSearchResults" class="search-dropdown-ios"></div>
                        </div>

                    </div>


                    <div id="aptActionError" class="ios-error-box" style="margin-bottom: 1.5rem;"></div>

                    <div id="aptConflictAlert" class="ios-conflict-alert-v2"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Flag to tell appointments.js that we are on a standalone page
        window.IS_CREATION_PAGE = true;

        document.addEventListener('DOMContentLoaded', function () {
            // Smart Title Logic: Auto-height and 50-word limit
            const aptSubject = document.getElementById('aptSubject');
            if (aptSubject) {
                const adjustHeight = () => {
                    aptSubject.style.height = 'auto';
                    aptSubject.style.height = aptSubject.scrollHeight + 'px';
                };

                aptSubject.addEventListener('input', function () {
                    if (this.value.length > 50) {
                        this.value = this.value.substring(0, 50);
                    }
                    adjustHeight();
                });

                adjustHeight();
            }

            // Centralized Sync Logic for Frontend -> Backend Data Integrity
            const hiddenStart = document.getElementById('aptStart');
            const hiddenEnd = document.getElementById('aptEnd');
            const dateDisp = document.getElementById('displayAptDate');
            const startDisp = document.getElementById('displayStartTime');
            const endDisp = document.getElementById('displayEndTime');

            function syncAptDateTime() {
                const dateVal = datePicker.selectedDates[0];
                const startT = startTimePicker.selectedDates[0];
                const endT = endTimePicker.selectedDates[0];

                if (dateVal && startT && endT) {
                    // Combine Date + Start Time
                    const start = new Date(dateVal);
                    start.setHours(startT.getHours(), startT.getMinutes(), 0);

                    // Combine Date + End Time
                    const end = new Date(dateVal);
                    end.setHours(endT.getHours(), endT.getMinutes(), 0);

                    // Guardrail: End must be after Start
                    if (end <= start) {
                        end.setTime(start.getTime() + 60 * 60000); // 1 hour default nudge
                        endTimePicker.setDate(end, false);
                    }

                    // Update Hidden ISO Values for Backend & Conflict Check
                    const toIso = (d) => d.getFullYear() + '-' +
                        String(d.getMonth() + 1).padStart(2, '0') + '-' +
                        String(d.getDate()).padStart(2, '0') + 'T' +
                        String(d.getHours()).padStart(2, '0') + ':' +
                        String(d.getMinutes()).padStart(2, '0');

                    const startISO = toIso(start);
                    hiddenStart.value = startISO;
                    hiddenEnd.value = toIso(end);

                    // Guardrail: Cannot schedule in the past (allow current minute)
                    const errDisp = document.getElementById('aptActionError');
                    const now = new Date();
                    now.setSeconds(0, 0); // Ignore seconds for a smoother "immediate" check

                    if (start < now) {
                        if (errDisp) {
                            errDisp.innerText = "Appointment cannot be in the past.";
                            errDisp.style.display = 'block';
                        }
                    } else {
                        if (errDisp && errDisp.innerText === "Appointment cannot be in the past.") {
                            errDisp.style.display = 'none';
                        }
                    }

                    // Update UI Pills
                    dateDisp.innerText = start.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                    startDisp.innerText = start.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                    endDisp.innerText = end.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });

                    // Trigger conflict check (in appointments.js)
                    hiddenStart.dispatchEvent(new Event('change'));
                }
            }

            // Inline Selection Logic
            window.toggleSuite = function (suiteId) {
                const suites = ['dateSuite', 'startSuite', 'endSuite'];
                suites.forEach(s => {
                    const el = document.getElementById(s);
                    if (s === suiteId) {
                        el.classList.toggle('expanded');
                    } else {
                        el.classList.remove('expanded');
                    }
                });
            };

            // Initialize Trendy Pickers (Flatpickr)
            const datePicker = flatpickr("#dateInput", {
                inline: true,
                enableTime: false,
                dateFormat: "Y-m-d",
                defaultDate: "today",
                minDate: "today",
                onChange: function (selectedDates, dateStr, instance) {
                    syncAptDateTime();
                    window.toggleSuite(null);
                }
            });

            const startTimePicker = flatpickr("#startTimeInput", {
                inline: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "10:00",
                onChange: function(selectedDates, dateStr, instance) {
                    syncAptDateTime();
                    window.toggleSuite(null);
                }
            });

            const endTimePicker = flatpickr("#endTimeInput", {
                inline: true,
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "11:00",
                onChange: function(selectedDates, dateStr, instance) {
                    syncAptDateTime();
                    window.toggleSuite(null);
                }
            });

            // Initial Sync
            setTimeout(syncAptDateTime, 100);

            // Real-time Visual Preview Logic
            const coverInput = document.getElementById('aptCoverInput');
            const coverPreview = document.getElementById('aptCoverPreview');

            if (coverInput && coverPreview) {
                coverInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            coverPreview.src = e.target.result;
                            coverPreview.style.opacity = '1';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endpush