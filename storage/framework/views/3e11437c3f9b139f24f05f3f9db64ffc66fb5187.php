<?php $__env->startSection('title', 'Admin – Daily Affirmations'); ?>

<?php $__env->startPush('styles'); ?>
<style>
@keyframes  floatIn { 0% { opacity:0; transform:translateY(16px); } 100% { opacity:1; transform:translateY(0); } }
.da-panel { max-width: 1200px; animation: floatIn 0.45s cubic-bezier(0.16,1,0.3,1) both; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<main class="dash">
<div class="adm-page">
<div class="adm-card da-panel">

  
  <div class="adm-card-header">
    <div>
      <h1>Daily Affirmations</h1>
      <div class="header-sub">Create, schedule, edit, and post the quote shown across the app.</div>
    </div>
    <button class="btn-header" onclick="openCreateModal()">
      <i data-lucide="plus" style="width:16px;height:16px;"></i> Add Affirmation
    </button>
  </div>

  <div style="padding: 24px 28px 0;">

    
    <?php if(session('success')): ?>
      <div class="adm-alert adm-alert-ok" style="margin-bottom:20px;">
        <i data-lucide="check-circle" style="width:16px;flex-shrink:0;"></i> <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>
    <?php if($errors->any()): ?>
      <div class="adm-alert adm-alert-err" style="margin-bottom:20px;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><div><?php echo e($e); ?></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>

    
    <div class="afm-spotlight">
      <h3><i data-lucide="sparkles" style="color:#a855f7;width:16px;"></i> Current Live Affirmation</h3>
      <?php if($currentAffirmation): ?>
        <div class="afm-quote">"<?php echo e($currentAffirmation->quote); ?>"</div>
        <div class="afm-meta">
          <span class="badge-status badge-live"><?php echo e($currentAffirmation->display_status); ?></span>
          <?php if($currentAffirmation->author): ?>
            <span><i data-lucide="user" style="width:13px;margin-right:3px;"></i><?php echo e($currentAffirmation->author); ?></span>
          <?php endif; ?>
          <?php if($currentAffirmation->publish_at): ?>
            <span><i data-lucide="clock" style="width:13px;margin-right:3px;"></i>Posted: <?php echo e($currentAffirmation->publish_at->format('M d, Y g:i A')); ?></span>
          <?php endif; ?>
        </div>
      <?php else: ?>
        <div class="afm-quote">"You are worthy of support and belonging. Your journey is unique, and every step forward is progress."</div>
        <div class="afm-meta">
          <span class="badge-status badge-draft">Fallback</span>
          <span>No published affirmation yet — the app is using the default fallback quote.</span>
        </div>
      <?php endif; ?>
    </div>

  </div>

  
  <div class="adm-table-wrap">
    <table class="adm-table">
      <thead>
        <tr>
          <th>Quote</th>
          <th>Status</th>
          <th>Schedule</th>
          <th>Created By</th>
          <th style="text-align:right;">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $affirmations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $affirmation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php
            $isCurrent = $currentAffirmation && $currentAffirmation->id === $affirmation->id;
            $state = strtolower($affirmation->display_status);
            $editState = ($state === 'live' || $state === 'offline') ? 'publish_now' : $state;
            $editPayload = [
              'id'            => $affirmation->id,
              'quote'         => $affirmation->quote,
              'author'        => $affirmation->author,
              'publish_state' => $editState,
              'scheduled_for' => $affirmation->publish_at ? $affirmation->publish_at->format('Y-m-d\\TH:i') : null,
            ];
          ?>
          <tr>
            <td style="max-width:300px;">
              <div style="line-height:1.5;margin-bottom:3px;">"<?php echo e(Str::limit($affirmation->quote, 80)); ?>"</div>
              <?php if($affirmation->author): ?>
                <div style="color:var(--adm-muted);font-size:0.83rem;">— <?php echo e($affirmation->author); ?></div>
              <?php endif; ?>
            </td>
            <td>
              <span class="badge-status badge-<?php echo e($state); ?>"><?php echo e($affirmation->display_status); ?></span>
              <?php if($isCurrent): ?>
                <div style="margin-top:6px;color:#059669;font-size:0.78rem;font-weight:700;display:flex;align-items:center;gap:3px;">
                  <i data-lucide="sparkles" style="width:11px;"></i> Currently shown
                </div>
              <?php endif; ?>
            </td>
            <td style="color:var(--adm-muted);font-size:0.84rem;">
              <?php if($affirmation->publish_at): ?>
                <?php echo e($affirmation->publish_at->format('M d, Y g:i A')); ?>

              <?php else: ?>
                Not scheduled
              <?php endif; ?>
            </td>
            <td style="color:var(--adm-muted);"><?php echo e(optional($affirmation->creator)->short_name ?? 'Admin'); ?></td>
            <td>
              <div style="display:flex;justify-content:flex-end;gap:7px;align-items:center;">
                <?php if($state === 'scheduled'): ?>
                  <form action="<?php echo e(route('admin.daily-affirmations.publish-now', $affirmation)); ?>" method="POST" style="margin:0;">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-act btn-act-post">
                      <i data-lucide="send" style="width:13px;"></i> Post Now
                    </button>
                  </form>
                <?php endif; ?>
                <button type="button" class="btn-act btn-act-edit"
                        data-edit='<?php echo json_encode($editPayload, 15, 512) ?>' onclick="openEditModal(this)">
                  <i data-lucide="edit-2" style="width:13px;"></i> Edit
                </button>
                <form action="<?php echo e(route('admin.daily-affirmations.destroy', $affirmation)); ?>" method="POST"
                      onsubmit="return confirm('Delete this affirmation?');" style="margin:0;">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn-act btn-act-del">
                    <i data-lucide="trash-2" style="width:13px;"></i> Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="5" class="adm-empty">No daily affirmations added yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>
</div>
</main>


<div class="adm-backdrop" id="createModal">
  <div class="adm-modal" style="max-width:580px;">
    <div class="adm-modal-head">
      <h2>Add New Affirmation</h2>
      <button class="adm-modal-close" type="button" onclick="closeCreateModal()"><i data-lucide="x"></i></button>
    </div>
    <div class="adm-modal-body">
      <form action="<?php echo e(route('admin.daily-affirmations.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="adm-form-group">
          <label for="quote">Quote</label>
          <textarea name="quote" id="quote" class="adm-form-control" required
                    placeholder="Write the affirmation quote here..."></textarea>
        </div>
        <div class="adm-form-group">
          <label for="author">Author or Source <span style="font-weight:normal;color:var(--adm-muted);">(Optional)</span></label>
          <input type="text" name="author" id="author" class="adm-form-control" placeholder="e.g. Maya Angelou">
        </div>
        <div class="adm-form-group">
          <label for="publish_state">Posting Option</label>
          <select name="publish_state" id="publish_state" class="adm-form-control"
                  onchange="toggleScheduleField(this, 'createScheduleWrap')">
            <option value="draft">Save as Draft</option>
            <option value="publish_now">Post Today / Post Now</option>
            <option value="scheduled">Schedule for Specific Day and Time</option>
          </select>
        </div>
        <div class="adm-form-group" id="createScheduleWrap" style="display:none;">
          <label for="scheduled_for">Schedule Date and Time
            <span style="font-weight:normal;color:var(--adm-muted);">(Philippine Time / PHT)</span>
          </label>
          <input type="datetime-local" name="scheduled_for" id="scheduled_for" class="adm-form-control">
        </div>
        <div class="adm-modal-actions">
          <button type="button" class="btn-adm-cancel" onclick="closeCreateModal()">Cancel</button>
          <button type="submit" class="btn-adm-save">
            <i data-lucide="save" style="width:14px;"></i> Save Affirmation
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="adm-backdrop" id="editModal">
  <div class="adm-modal" style="max-width:580px;">
    <div class="adm-modal-head">
      <h2>Edit Affirmation</h2>
      <button class="adm-modal-close" type="button" onclick="closeEditModal()"><i data-lucide="x"></i></button>
    </div>
    <div class="adm-modal-body">
      <form id="editForm" method="POST">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="adm-form-group">
          <label for="edit_quote">Quote</label>
          <textarea name="quote" id="edit_quote" class="adm-form-control" required></textarea>
        </div>
        <div class="adm-form-group">
          <label for="edit_author">Author or Source <span style="font-weight:normal;color:var(--adm-muted);">(Optional)</span></label>
          <input type="text" name="author" id="edit_author" class="adm-form-control">
        </div>
        <div class="adm-form-group">
          <label for="edit_publish_state">Posting Option</label>
          <select name="publish_state" id="edit_publish_state" class="adm-form-control"
                  onchange="toggleScheduleField(this, 'editScheduleWrap')">
            <option value="draft">Save as Draft</option>
            <option value="publish_now">Post Today / Post Now</option>
            <option value="scheduled">Schedule for Specific Day and Time</option>
          </select>
        </div>
        <div class="adm-form-group" id="editScheduleWrap" style="display:none;">
          <label for="edit_scheduled_for">Schedule Date and Time</label>
          <input type="datetime-local" name="scheduled_for" id="edit_scheduled_for" class="adm-form-control">
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

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => { if (typeof lucide !== 'undefined') lucide.createIcons(); });

function toggleScheduleField(sel, wrapId) {
  const w = document.getElementById(wrapId);
  if (w) w.style.display = sel.value === 'scheduled' ? 'block' : 'none';
}
function openCreateModal()  { document.getElementById('createModal').classList.add('open'); }
function closeCreateModal() { document.getElementById('createModal').classList.remove('open'); }
function openEditModal(btn) {
  const p = JSON.parse(btn.dataset.edit || '{}');
  const modal = document.getElementById('editModal');
  const form  = document.getElementById('editForm');
  if (!p.id || !modal || !form) return;
  form.action = '/admin/daily-affirmations/' + p.id;
  document.getElementById('edit_quote').value         = p.quote || '';
  document.getElementById('edit_author').value        = p.author || '';
  document.getElementById('edit_publish_state').value = p.publish_state || 'draft';
  document.getElementById('edit_scheduled_for').value = p.scheduled_for || '';
  toggleScheduleField(document.getElementById('edit_publish_state'), 'editScheduleWrap');
  modal.classList.add('open');
}
function closeEditModal() { document.getElementById('editModal').classList.remove('open'); }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\websystem\resources\views/admin/daily_affirmations/index.blade.php ENDPATH**/ ?>