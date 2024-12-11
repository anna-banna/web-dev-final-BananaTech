<?php require 'includes/header.php'; ?>

<section>
    <h2>Our Services</h2>
    <p>At BananaTech, we pride ourselves on offering a diverse range of IT services designed to meet the unique needs of our clients. Learn more about each of our specialized services below.</p>

    <div class="service">
        <button class="accordion">Custom Software Development</button>
        <div class="panel">
            <p>Our Custom Software Development service provides tailored software solutions that are designed to fit your specific business needs. Whether you require a new application, modifications to existing software, or a complete system overhaul, our experienced developers will work with you to create a solution that enhances efficiency and drives business growth. We use the latest technologies and best practices to ensure your software is scalable, secure, and user-friendly.</p>
        </div>
    </div>

    <div class="service">
        <button class="accordion">IT Infrastructure Management</button>
        <div class="panel">
            <p>Effective IT Infrastructure Management is critical to maintaining the performance and reliability of your IT systems. Our team provides comprehensive management services, including monitoring, maintenance, and optimization of your hardware and network resources. We ensure that your infrastructure is robust, secure, and capable of supporting your business operations efficiently.</p>
        </div>
    </div>

    <div class="service">
        <button class="accordion">Cloud Computing Solutions</button>
        <div class="panel">
            <p>Our Cloud Computing Solutions offer flexibility and scalability for your business operations. We provide cloud-based services that include data storage, computing power, and application hosting. By leveraging cloud technology, we help you reduce costs, enhance collaboration, and scale your resources based on demand. Our solutions are designed to improve your business agility and support your growth strategies.</p>
        </div>
    </div>

    <div class="service">
        <button class="accordion">Network Security Services</button>
        <div class="panel">
            <p>Protecting your data and systems from cyber threats is a top priority. Our Network Security Services include risk assessments, threat detection, and response strategies to safeguard your IT environment. We implement advanced security measures and regularly update your systems to defend against emerging threats, ensuring the confidentiality and integrity of your business data.</p>
        </div>
    </div>

    <div class="service">
        <button class="accordion">IT Support and Maintenance</button>
        <div class="panel">
            <p>Our IT Support and Maintenance services ensure that your technology systems remain operational and efficient. We offer proactive support to prevent issues, as well as responsive troubleshooting to address any problems that arise. Our team is available to provide technical assistance, system updates, and regular maintenance to keep your IT infrastructure running smoothly.</p>
        </div>
    </div>
</section>

<?php
if (!isset($_SESSION['email'])) {
    echo '<section>';
    echo '<h3>Join Us Today</h3>';
    echo '<p>Whether you\'re a small business looking to streamline operations or a large corporation in need of enterprise-level solutions, BananaTech has the expertise to help you succeed. Contact us today to learn more about our services and how we can help your business thrive.</p>';
    echo '<p>If you\'re ready to get started, please <a href="sign_up.php">sign up</a> for an account to become a part of the BananaTech community.</p>';
    echo '</section>';
}
?>

<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>

<?php require 'includes/footer.php'; ?>