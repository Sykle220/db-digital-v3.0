<?php
/**
 * @var \CodeIgniter\Pager\PagerRenderer|null $pager
 */
if (isset($pager)) {
    echo view('admin/components/pager', ['pager' => $pager]);
}
