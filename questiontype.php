<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Question type class for the sphinx question type.
 *
 * @package    qtype
 * @subpackage sphinx
 * @copyright  2005 Mark Nielsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');

/**
 * The sphinx question type.
 *
 * @copyright  2005 Mark Nielsen
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_sphinx extends question_type {
    public function is_manual_graded() {
        return true;
    }

    public function response_file_areas() {
        return array('attachments');
    }

    public function get_question_options($question) {
    }

    protected function initialise_question_instance(question_definition $question, $questiondata) {
        question_type::initialise_question_instance($question, $questiondata);
    }

    public function move_files($questionid, $oldcontextid, $newcontextid) {
        question_type::move_files($questionid, $oldcontextid, $newcontextid);
        $fs = get_file_storage();
        $fs->move_area_files_to_new_context($oldcontextid,
                $newcontextid, 'qtype_sphinx', 'graderinfo', $questionid);
    }

    protected function delete_files($questionid, $contextid) {
        question_type::delete_files($questionid, $contextid);
        $fs = get_file_storage();
        $fs->delete_area_files($contextid, 'qtype_sphinx', 'graderinfo', $questionid);
    }
}
