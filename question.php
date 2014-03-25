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
 * sphinx question definition class.
 *
 * @package    qtype
 * @subpackage sphinx
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

/**
 * Represents an sphinx question.
 *
 * @copyright  2009 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_sphinx_question extends question_with_responses {

    public function make_behaviour(question_attempt $qa, $preferredbehaviour) {
        return question_engine::make_behaviour('manualgraded', $qa, $preferredbehaviour);
    }

    public function get_expected_data() {
        return array('attachments' => question_attempt::PARAM_FILES);
    }

    public function summarise_response(array $response) {
        return null;
    }

    public function get_correct_response() {
        return null;
    }

    public function is_complete_response(array $response) {
        $hasattachments = array_key_exists('attachments', $response) &&
                            $response['attachments'] instanceof  question_response_files;

        // Determine the number of attachments present.
        if ($hasattachments) {
            return count($response['attachments']->get_files()) > 0;
        } else {
            return false;
        }
    }

    public function is_same_response(array $prevresponse, array $newresponse) {
        return question_utils::arrays_same_at_key_missing_is_blank($prevresponse, $newresponse, 'attachments');
    }

    public function check_file_access($qa, $options, $component, $filearea, $args, $forcedownload) {
        if ($component == 'question' && $filearea == 'response_attachments') {
            // Response attachments visible if the question has them.
            return true;
        } else {
            return parent::check_file_access($qa, $options, $component, $filearea, $args, $forcedownload);
        }
    }
}
