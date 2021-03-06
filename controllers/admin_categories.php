<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
* FAQ
*
* @package FAQ
* @author Lorenzo García <contact@lorenzo-garcia.com>
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-ShareAlike 3.0 Unported
* @link http://lorenzo-garcia.com
*/

class Admin_categories extends Admin_Controller
{
    protected $section = 'categories';
    public $namespace = 'faq';
    public $stream = 'categories';

    public function __construct()
    {
        parent::__construct();
        $this->load->driver('streams');
    }

    public function index()
    {
        role_or_die('faq', 'admin');

        $extra['title'] = lang($this->namespace.':label:'.$this->stream);

        $extra['buttons'][] = array(
            'label'     => lang('global:edit'),
            'url'       => 'admin/'.$this->namespace.'/'.$this->stream.'/edit/-entry_id-'
            );
        $extra['buttons'][] = array(
            'label'     => lang('global:delete'),
            'url'       => 'admin/'.$this->namespace.'/'.$this->stream.'/delete/-entry_id-',
            'confirm'   => true
            );
        $extra['sorting'] = true;

        $this->streams->cp->entries_table($this->stream, $this->namespace, null, null, true, $extra);
    }

    public function create()
    {
        role_or_die('faq', 'admin');

        $extra = array(
            'return'            => 'admin/'.$this->namespace.'/'.$this->stream,
            'success_message'   => lang('global:message:create:success'),
            'failure_message'   => lang('global:message:create:failure'),
            'title'             => lang('global:label:create'),
            );
        $this->streams->cp->entry_form($this->stream, $this->namespace, 'new', null, true, $extra);
    }

    public function edit($entry_id = null)
    {
        role_or_die('faq', 'admin');

        $extra = array(
            'return'            => 'admin/'.$this->namespace.'/'.$this->stream,
            'success_message'   => lang('global:message:edit:success'),
            'failure_message'   => lang('global:message:edit:failure'),
            'title'             => lang('global:label:edit'),
            );
        $this->streams->cp->entry_form($this->stream, $this->namespace, 'edit', $entry_id, true, $extra);
    }

    public function delete($entry_id = 0)
    {
        role_or_die('faq', 'admin');

        $this->streams->entries->delete_entry($entry_id, $this->stream, $this->namespace);
        $this->session->set_flashdata('error', lang('global:message:delete:success'));
        redirect('admin/'.$this->namespace.'/'.$this->stream);
    }
}

/* End of file admin_categories.php */
