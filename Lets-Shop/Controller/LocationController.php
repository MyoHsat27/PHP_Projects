<?php
require_once ModelDir."/Location.php";

class LocationController {
    private object $location;

    public function __construct() {
        $this->location = new Location();
    }

    // View Functions
    public function index(): void {
        view("admin/location/location");
    }

    public function createView(): void {
        view("admin/location/create");
    }

    public function updateView(): void {
        $stateData = $this->location->getStateId($_GET['id']);
        $towns = $this->location->getRelatedTowns($_GET['id']);
        if ($stateData) {
            view("admin/location/update", ['stateData' => $stateData, "towns" => $towns]);
        } else {
            redirect(route("admin/location"), "No Such Location", "error");
        }
    }

    public function detailView(): void {
        view("admin/location/detail");
    }

    // Operation Functions
    public function create(): void {
        $stateName = $_POST['stateName'];
        $locationActive = isset($_POST['locationActive']) ?? 0;
        $townNames = $_POST['townName'];
        $townPrices = $_POST['townPrice'];

        if ($stateId = $this->location->createState($stateName, $locationActive)) {
            if ($townNames[0] != null) {
                foreach ($townNames as $index => $townName) {
                    $this->location->createTown($townName, $townPrices[$index], $stateId);
                }
            }
            redirect(route("admin/location"), "Added $stateName Successfully");
        } else {
            redirectBack("Error in creating new state");
        }
    }

    public function update(): void {
        if (isset($_POST)) {
            $stateId = $_POST['stateId'];
            $stateName = $_POST['stateName'];
            $locationActive = isset($_POST['locationActive']) ?? 0;

            $result = false;

            $newTownsId = $_POST['townNewId'] ?? []; // Get removed town id
            $newTownsName = $_POST['townNewName'] ?? [];
            $newTownsPrice = $_POST['townNewPrice'] ?? [];

            $oldTownsId = $_POST['townId'] ?? [];
            $oldTownsName = $_POST['townName'] ?? [];
            $oldTownsPrice = $_POST['townPrice'] ?? [];

            // Adding New Town
            if (!empty($newTownsId)) {
                foreach ($newTownsId as $index => $newTownId) {
                    if (!in_array($newTownId, $oldTownsId)) {
                        print_r($newTownId." - new town : ".$newTownsName[$index]." : ".$newTownsPrice[$index]." | ");
                        $result = $this->location->createTown($newTownsName[$index], $newTownsPrice[$index], $stateId);
                    }
                }
            }

            if (!empty($oldTownsId)) {
                foreach ($oldTownsId as $index => $oldTownId) {
                    if (!in_array($oldTownId, $newTownsId)) { // Removing Old Town
                        print_r($oldTownId." - old town : ".$oldTownsName[$index]." : ".$oldTownsPrice[$index]." | ");
                        $result = $this->location->deleteTown($oldTownId);
                    } else { // Editing Old Town
                        print_r($oldTownId." Edit | ");
                        $result = $this->location->updateTown($newTownsName[$index],
                            $newTownsPrice[$index], $stateId, $oldTownId);
                    }
                }
            }


            $result = $this->location->updateState($stateName, $locationActive, $stateId);


            if (!$result) {
                redirectBack("Could not edit", "error");
            }
            redirect(route("admin/location"),"State edited successfully");
        }
    }
}