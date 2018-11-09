<!DOCTYPE html>
<html>
	
<head>
	
</head>
<body style="font-family:'Arial Black';">

    <table width="100%">
        <tbody>
            <tr>
                <td width="20%"></td>
                <td align="center" style="height: 80px; background-color: #009BDB; color: white; font-weight: bold;">
                    <?php echo e($companyName); ?>

                </td>
                <td width="20%"></td>
            </tr>

            <tr style="border-collapse: collapse;">
                <td></td>
                <td align="center" style="height: 150px; background-color: #c7efff; color: black; font-weight: bold;"><?php echo e($body); ?></td>
                <td></td>
            </tr>

            <tr style="border-collapse: collapse;">
                <td></td>
                <td align="center" style="height: 50px; background-color: #c7efff; color: black; font-weight: bold;"><?php echo e($legend); ?></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td align="center" style="height: 80px; background-color: #009BDB; color: white; font-weight: bold;">
                    Aplicación de Facturación Electrónica
                    <br>                                        
                    <strong>Copyright</strong> Quantum &copy; <?php echo e(date('Y')); ?>

                    <br><br>
                    Ésta es una cuenta de correo no monitoreada, si desea más información por favor contáctenos a través del correo electrónico
                    <br>
                    <strong style="color: white; text-decoration: none"><?php echo e($mailResponse); ?></strong>                    
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>


</body>
</html>
