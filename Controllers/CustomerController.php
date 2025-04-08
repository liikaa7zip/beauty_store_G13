<?php

    
    require_once "Models/CustomerModel.php";
    class CustomerController extends BaseController
{
    private $customerModel;
    private $db;
    private $productModel; // Assuming you have a ProductModel for product-related operations


    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->db = new Database();
    }

    public function index()
{
    try {
        // Get all customers
        $customers = $this->customerModel->getAllCustomers();
        
        // Pass data to view
        return $this->view('/customers/view', [
            'customers' => $customers
        ]);

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $this->redirect('/customers/view');
    }
}

// In CustomerController.php
public function viewCustomerDetails($id)
{
    try {
        // Fetch the customer details from the database
        $customer = $this->customerModel->getCustomerById($id);

        if (!$customer) {
            throw new Exception('Customer not found.');
        }

        // Fetch the unpaid products for this customer
        $unpaidProducts = $this->customerModel->getUnpaidProductsByCustomerId($id);
        
        // Pass data to the view
        return $this->view('customers/detail', [
            'customer' => $customer,
            'unpaidProducts' => $unpaidProducts
        ]);
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $this->redirect('/customers');
    }
}



public function show($customerId)
{
    try {
        // Get customer details
        $customer = $this->customerModel->getCustomerById($customerId);
        
        if (!$customer) {
            throw new Exception('Customer not found');
        }

        // Get unpaid products for the customer
        $unpaidProducts = $this->customerModel->getUnpaidProductsByCustomerId($customerId);
        
        // Pass data to the view
        return $this->view('/customers/view', [
            'customer' => $customer,
            'unpaidProducts' => $unpaidProducts
        ]);

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $this->redirect('/sales');
    }
}


    // In CustomerController.php
    public function pay()
{
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Invalid request method');
        }

        $customerId = $_POST['customer_id'] ?? null;
        $paymentAmount = floatval($_POST['payment_amount'] ?? 0);

        if (!$customerId || $paymentAmount <= 0) {
            throw new Exception('Invalid payment data');
        }

        // Fetch the customer
        $customer = $this->customerModel->getCustomerById($customerId);
        if (!$customer) {
            throw new Exception('Customer not found');
        }

        if ($paymentAmount > $customer['total_debt']) {
            throw new Exception('Payment amount cannot exceed the total debt');
        }

        // Update the debt after payment
        $newDebt = $customer['total_debt'] - $paymentAmount;
        if (!$this->customerModel->updateCustomerDebt($customerId, $newDebt)) {
            throw new Exception('Failed to update customer debt');
        }

        // Log the payment
        if (!$this->customerModel->logPayment($customerId, $paymentAmount)) {
            throw new Exception('Failed to log payment');
        }

        $_SESSION['success'] = "Payment of $" . number_format($paymentAmount, 2) . " was successful.";
        $this->redirect("/customers");  // Redirect to main customers page

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $this->redirect("/customers");  // Redirect to main customers page even on error
    }
}
    


     // In CustomerController.php (pay method)
     private function logPayment($customerId, $paymentAmount)
     {
         $sql = "INSERT INTO payments (customer_id, payment_amount, payment_date) 
                 VALUES (:customer_id, :payment_amount, NOW())";
         $params = [
             ':customer_id' => $customerId,
             ':payment_amount' => $paymentAmount
         ];
     
         return $this->db->query($sql, $params);
     }

     public function create() 
{
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception('Invalid request method');
        }

        // Validate required fields
        $required = ['name', 'phone', 'address'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("$field is required");
            }
        }

        // Prepare customer data
        $customerData = [
            'name' => $_POST['name'],
            'phone' => $_POST['phone'],
            'address' => $_POST['address'],
            'total_debt' => floatval($_POST['total_debt'] ?? 0)
        ];

        // Create customer
        $success = $this->customerModel->createCustomer($customerData);

        if (!$success) {
            throw new Exception('Failed to create customer');
        }

        $_SESSION['success'] = "Customer created successfully!";
        $this->redirect('/customers');

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $this->redirect('/customers');
    }
}

    // In CustomerController.php
public function showCustomersWithDebt()
{
    try {
        // Fetch customers with debt
        $customersWithDebt = $this->customerModel->getCustomersWithDebt();
        
        // Pass data to view
        return $this->view('/customers/view', [
            'customersWithDebt' => $customersWithDebt
        ]);

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        $this->redirect('/customers/view');
    }
}

public function viewCustomer($customerId)
{
    try {
        // Fetch customer details
        $customer = $this->customerModel->getCustomerById($customerId);
        
        // Fetch unpaid products for the customer
        $unpaidProducts = $this->productModel->getUnpaidProductsByCustomerId($customerId);
        
        // Pass customer and unpaid products data to the view
        return $this->view('customer/detail', [
            'customer' => $customer,
            'unpaidProducts' => $unpaidProducts
        ]);
    } catch (Exception $e) {
        $_SESSION['error'] = 'Customer not found.';
        $this->redirect('/customers'); // Redirect to the customer list page
    }
}

    public function delete($customerId)
{
    try {
        // Delete customer
        $this->customerModel->delete($customerId);
        
        $_SESSION['success'] = "Customer deleted successfully!";
        $this->redirect('/customers');
    } catch (Exception $e) {
       
        $this->redirect('/customers');
    }


    }

    
}