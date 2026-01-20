<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mathematics - Course View</title>
    <style>
        /* Base Styles from Dashboard */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: system-ui, -apple-system, sans-serif; background-color: #f1f5f9; display: flex; height: 100vh; }
        
        /* Sidebar & Layout */
        .sidebar { width: 260px; background-color: #1e293b; color: white; display: flex; flex-direction: column; flex-shrink: 0; }
        .sidebar-header { height: 64px; display: flex; align-items: center; padding: 0 1.5rem; font-size: 1.5rem; font-weight: 800; color: #3b82f6; border-bottom: 1px solid #334155; }
        .nav-links { list-style: none; padding: 1rem 0; flex: 1; }
        .nav-links li a { display: flex; align-items: center; gap: 12px; padding: 0.85rem 1.5rem; color: #cbd5e1; text-decoration: none; font-weight: 500; border-left: 4px solid transparent; }
        .nav-links li a:hover, .nav-links li a.active { background-color: #334155; color: white; border-left-color: #3b82f6; }
        
        .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        .top-bar { height: 64px; background: white; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; padding: 0 2rem; }
        .content-area { flex: 1; overflow-y: auto; padding: 2rem; }

        /* --- COURSE STYLES (Week Layout) --- */
        .course-header-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%); /* Green Theme */
            color: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
        }

        .week-section { margin-bottom: 2.5rem; }
        .week-title { 
            font-size: 1.25rem; font-weight: 700; color: #0f172a; 
            margin-bottom: 1rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem;
            display: flex; align-items: center; gap: 10px;
        }

        /* File Card */
        .material-card {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px;
            padding: 1.5rem; margin-bottom: 1rem; 
            display: flex; align-items: flex-start; gap: 1rem;
            transition: all 0.2s;
        }
        .material-card:hover { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); transform: translateY(-2px); }
        
        .file-icon {
            width: 48px; height: 48px; background: #fee2e2; color: #ef4444;
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; flex-shrink: 0;
        }
        
        .material-info h4 { margin: 0 0 0.5rem 0; font-size: 1.1rem; color: #3b82f6; }
        .material-info p { margin: 0; color: #64748b; font-size: 0.9rem; line-height: 1.5; }
        
        .action-group { margin-left: auto; display: flex; gap: 8px; align-items: center; }
        .btn-icon {
            background: none; border: 1px solid #e2e8f0; border-radius: 4px;
            padding: 6px 10px; cursor: pointer; color: #64748b; transition: 0.2s;
        }
        .btn-icon:hover { background: #f1f5f9; color: #0f172a; }

        .btn-download {
            text-decoration: none; font-size: 0.85rem; font-weight: bold;
            color: #10b981; border: 1px solid #10b981; padding: 5px 12px;
            border-radius: 4px; transition: 0.2s;
        }
        .btn-download:hover { background: #10b981; color: white; }

        /* --- MODAL STYLES --- */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 1000;
        }
        .modal-box {
            background: white; width: 500px; padding: 2rem; border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: #334155; }
        .form-control {
            width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.95rem;
        }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">LearnEase</div>
        <ul class="nav-links">
            <li><a href="{{ route('teacherView.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('subjects') }}" class="active">Subjects</a></li>
        </ul>
    </aside>

    <div class="main-wrapper">
        <header class="top-bar">
            <h2 style="font-size: 1.25rem; font-weight: bold; color: #0f172a;">Mathematics (MATH-101)</h2>
            <div style="font-weight: bold; color: #334155;">Teacher View</div>
        </header>

        <main class="content-area">
            
            <div class="course-header-card">
                <div>
                    <h1 style="margin: 0; font-size: 1.8rem;">General Mathematics</h1>
                    <p style="margin-top: 0.5rem; opacity: 0.9;">Dr. Alan Smith • Fall Semester 2025</p>
                </div>
                <button onclick="openModal('add')" style="background: white; color: #059669; border: none; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    + Add Tutoring File
                </button>
            </div>

            @forelse($materials as $week => $items)
                <div class="week-section">
                    <div class="week-title">
                        <span>📅</span> {{ $week }}
                    </div>

                    @foreach($items as $item)
                    <div class="material-card">
                        <div class="file-icon">📄</div>
                        <div class="material-info">
                            <h4>{{ $item->title }}</h4>
                            <p>
                                {{ $item->description }} <br>
                                <span style="font-size: 0.8rem; opacity: 0.7;">Posted: {{ $item->created_at->diffForHumans() }}</span>
                            </p>
                            
                            @if($item->file_path)
                                <div style="margin-top: 10px;">
                                    <a href="{{ route('material.download', $item->id) }}" class="btn-download">
                                        ⬇️ Download File
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <div class="action-group">
                            <button class="btn-icon" onclick="openModal('edit', {{ json_encode($item) }})" title="Edit Details">✏️</button>
                            
                            <form action="{{ route('material.delete', $item->id) }}" method="POST" onsubmit="return confirmDelete('{{ $item->title }}')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-icon" style="color: #ef4444;" title="Delete File">🗑️</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @empty
                <div style="text-align: center; padding: 4rem; color: #94a3b8; border: 2px dashed #e2e8f0; border-radius: 12px;">
                    <h3>No materials found.</h3>
                    <p>Click "Add Tutoring File" to upload the first document.</p>
                </div>
            @endforelse

        </main>
    </div>

    <div id="materialModal" class="modal-overlay">
        <div class="modal-box">
            <h2 id="modalTitle" style="margin-bottom: 1.5rem; color: #0f172a;">Add New Material</h2>
            
            <form id="materialForm" method="POST" action="{{ route('material.store') }}" enctype="multipart/form-data" onsubmit="return reviewAndSubmit(event)">
                @csrf
                <div id="methodField"></div> 

                <div class="form-group">
                    <label>Week / Section Title</label>
                    <input type="text" name="week_title" id="weekInput" class="form-control" placeholder="e.g. Week 2 (13 Oct - 17 Oct)" required>
                </div>

                <div class="form-group">
                    <label>File Title</label>
                    <input type="text" name="title" id="titleInput" class="form-control" placeholder="e.g. Algebra Homework 1" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="descInput" class="form-control" rows="2" placeholder="Instructions..."></textarea>
                </div>

                <div class="form-group" id="fileGroup">
                    <label>Upload File (PDF, DOCX, PPTX)</label>
                    <input type="file" name="file_upload" id="fileInput" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx">
                    <small style="color: #64748b;">Max Size: 10MB</small>
                </div>

                <div style="display: flex; gap: 10px; margin-top: 2rem; justify-content: flex-end;">
                    <button type="button" onclick="closeModal()" style="padding: 10px 20px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; cursor: pointer;">Cancel</button>
                    <button type="submit" style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Review & Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('materialModal');
        const form = document.getElementById('materialForm');
        
        function openModal(mode, data = null) {
            modal.style.display = 'flex';
            
            if (mode === 'edit' && data) {
                // EDIT MODE
                document.getElementById('modalTitle').innerText = "Edit Details";
                form.action = "/material/update/" + data.id;
                document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                // Pre-fill data
                document.getElementById('weekInput').value = data.week_title;
                document.getElementById('titleInput').value = data.title;
                document.getElementById('descInput').value = data.description;
                
                // Hide file input (Edit logic in this demo only updates text)
                document.getElementById('fileGroup').style.display = 'none';
                document.getElementById('fileInput').required = false;
            } else {
                // ADD MODE
                document.getElementById('modalTitle').innerText = "Add New Material";
                form.action = "{{ route('material.store') }}";
                document.getElementById('methodField').innerHTML = '';
                form.reset();
                
                // Show file input
                document.getElementById('fileGroup').style.display = 'block';
                document.getElementById('fileInput').required = true;
            }
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        // III. Notification Review Check
        function reviewAndSubmit(event) {
            const title = document.getElementById('titleInput').value;
            const week = document.getElementById('weekInput').value;
            const fileInput = document.getElementById('fileInput');
            
            // Sanitation Check
            if(title.includes('<') || title.includes('>')) {
                alert("Please remove special characters like < or >");
                return false;
            }

            let fileName = "No file changed";
            if(fileInput.files.length > 0) {
                fileName = fileInput.files[0].name;
            }

            // Review Dialog
            const msg = "⚠️ REVIEW BEFORE SAVING \n\n" +
                        "SECTION: " + week + "\n" +
                        "TITLE: " + title + "\n" +
                        "FILE: " + fileName + "\n" +
                        "----------------------------\n" +
                        "Is this information correct?";
            
            return confirm(msg);
        }

        // I. Confirm Deletion
        function confirmDelete(itemName) {
            return confirm("⚠️ CONFIRM DELETION \n\nAre you sure you want to delete '" + itemName + "'?\nThis action cannot be undone.");
        }
    </script>
</body>
</html>