<?php $__env->startSection('title', 'Admin – Professional Titles'); ?>

<?php $__env->startPush('styles'); ?>
<style>
@keyframes  floatIn { 0% { opacity:0; transform:translateY(16px); } 100% { opacity:1; transform:translateY(0); } }
.pt-panel { max-width: 1000px; animation: floatIn 0.45s cubic-bezier(0.16,1,0.3,1) both; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main class="dash">
<div class="adm-page">
<div class="adm-card pt-panel">

  
  <div class="adm-card-header">
    <h1>Professional Titles</h1>
    <button class="btn-header" onclick="openCreateModal()">
      <i data-lucide="plus" style="width:16px;height:16px;"></i> Add New Title
    </button>
  </div>

  
  <?php if(session('success')): ?>
    <div style="padding: 16px 28px 0;">
      <div class="adm-alert adm-alert-ok">
        <i data-lucide="check-circle" style="width:16px;flex-shrink:0;"></i> <?php echo e(session('success')); ?>

      </div>
    </div>
  <?php endif; ?>
  <?php if($errors->any()): ?>
    <div style="padding: 16px 28px 0;">
      <div class="adm-alert adm-alert-err">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  <?php endif; ?>

  
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Title Name</th>
          <th>Created On</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><span class="title-chip"><?php echo e($title->name); ?></span></td>
            <td style="color: var(--adm-muted);"><?php echo e($title->created_at->format('M d, Y')); ?></td>
            <td>
              <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" class="btn-act btn-act-edit"
                        onclick="openEditModal(<?php echo e($title->id); ?>, '<?php echo e(addslashes($title->name)); ?>')">
                  <i data-lucide="edit-2" style="width:13px;"></i> Edit
                </button>
                <form action="<?php echo e(route('admin.professional-titles.destroy', $title->id)); ?>" method="POST"
                      onsubmit="return confirm('Delete this title?');" style="margin:0;">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn-act btn-act-del">
                    <i data-lucide="trash-2" style="width:13px;"></i> Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="3" class="adm-empty">No professional titles added yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
</div>
</main>


<div class="adm-backdrop" id="createModal">
  <div class="adm-modal">
    <div class="adm-modal-head">
      <h2>Add Professional Title</h2>
      <button class="adm-modal-close" onclick="closeCreateModal()"><i data-lucide="x"></i></button>
    </div>
    <div class="adm-modal-body">
      <form action="<?php echo e(route('admin.professional-titles.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="adm-form-group">
          <label for="name">Title Name</label>
          <input type="text" name="name" id="name" class="adm-form-control"
                 required placeholder="e.g. Clinical Psychologist">
        </div>
        <div class="adm-modal-actions">
          <button type="button" class="btn-adm-cancel" onclick="closeCreateModal()">Cancel</button>
          <button type="submit" class="btn-adm-save">
            <i data-lucide="plus" style="width:14px;"></i> Add Title
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="adm-backdrop" id="editModal">
  <div class="adm-modal">
    <div class="adm-modal-head">
      <h2>Edit Professional Title</h2>
      <button class="adm-modal-close" onclick="closeEditModal()"><i data-lucide="x"></i></button>
    </div>
    <div class="adm-modal-body">
      <form id="editForm" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="adm-form-group">
          <label for="editNameInput">Title Name</label>
          <input type="text" name="name" id="editNameInput" class="adm-form-control" required>
        </div>
        <div class="adm-modal-actions">
          <button type="button" class="btn-adm-cancel" onclick="closeEditModal()">Cancel</button>
          <button type="submit" class="btn-adm-save">
            <i data-lucide="save" style="width:14px;"></i> Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); });
function openCreateModal()  { document.getElementById('createModal').classList.add('open'); }
function closeCreateModal() { document.getElementById('createModal').classList.remove('open'); }
function openEditModal(id, name) {
  document.getElementById('editForm').action = `/admin/professional-titles/${id}`;
  document.getElementById('editNameInput').value = name;
  document.getElementById('editModal').classList.add('open');
}
function closeEditModal() { document.getElementById('editModal').classList.remove('open'); }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\websystem\resources\views/admin/professional_titles/index.blade.php ENDPATH**/ ?>