
# **Cafe Menu Manager**  

Cafe Menu Manager is a modern web-based application designed to streamline the ordering process for cafes. It allows customers and baristas to place food orders, which are sent directly to the cashier for processing. The system also supports automatic order printing and real-time table status updates using WebSocket technology.  

## **Key Features**  

- **Order Management**:  
  Customers and baristas can order food seamlessly through the application, with orders sent directly to the cashier.  

- **Real-Time Table Status Updates**:  
  Utilizing WebSockets, the application provides live updates on table statuses to ensure efficient table management.  

- **Multi-Database Architecture**:  
  - **Retail System Database**: Retrieves essential menu and pricing data from the retail system.  
  - **Order Management Database**: Handles order and image storage for optimal separation of concerns.  

- **Automatic Order Printing**:  
  Orders are automatically printed for processing, reducing manual effort.  

- **Technology Stack**:  
  - Backend: Laravel (utilizing Laravel WebSockets for real-time communication).  
  - Frontend: Vue.js for an interactive user interface.  
  - Communication: WebSocket and API for seamless data exchange.  

---

## **Project Structure**  

- **Backend**: Handles business logic, WebSocket communication, and database operations using Laravel.  
- **Frontend**: Built with Vue.js for dynamic and interactive user interfaces.  
- **WebSocket Communication**: Facilitates real-time updates for table statuses and order notifications.  

---

## **License**  

This project is licensed under the [MIT License](LICENSE).  

---

## **Acknowledgments**  

- Built using Laravel and Vue.js.  
- WebSocket support implemented using Laravel WebSockets.  
