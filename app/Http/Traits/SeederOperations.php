<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Site;
use App\Models\Organization;
use App\Models\Person;
use App\Models\User;
use App\Models\ActivityType;
use App\Models\Allergen;
use App\Models\BudgetCategory;
use App\Models\BudgetType;
use App\Models\Disease;
use App\Models\EventType;
use App\Models\Group;
use App\Models\LifestyleCategory;
use App\Models\Lifestyle;
use App\Models\Measurement;
use App\Models\MedicationCategory;
use App\Models\Medication;
use App\Models\MedicationMedicationCategory;
use App\Models\PatientStatus;
use App\Models\PersonType;
use App\Models\Phase;
use App\Models\Procedure;
use App\Models\ProviderType;
use App\Models\RecruitmentSource;
use App\Models\RecruitmentSourceType;
use App\Models\ResourceType;
use App\Models\Resource;
use App\Models\StudyPatientStatus;
use App\Models\StudySource;
use App\Models\StudyStatus;
use App\Models\TherapeuticArea;
use App\Models\Workflow;
use App\Models\HumanSystem;
use App\Models\UserSite;
use App\Models\Event;
use App\Models\EventPerson;
use App\Models\Patient;
use App\Models\Study;
use App\Models\Permission;
use App\Models\StudyPatient;
use App\Models\Provider;
use App\Models\Phone;
use App\Models\VttCommand;
use App\Models\OrganizationContact;
use App\Models\StudySubInvestigator;
use App\Models\PatientAllergy;
use App\Models\PatientMedicalHistory;
use App\Models\PatientFamilyMedicalHistory;
use App\Models\PatientMeasurement;
use App\Models\PatientLifestyle;
use App\Models\PatientMedication;
use App\Models\Notification;
use App\Models\PatientVisit;
use App\Models\Task;
use Illuminate\Support\Facades\Schema;

trait SeederOperations
{
    /**
     * Validates the 'patient_id' parameter and returns the value.
     * Throws an exception if the parameter is missing or invalid.
     *
     * @param  Request  $request
     * @return int
     *
     * @throws \InvalidArgumentException
     */
    protected function importCsv($filename, $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
