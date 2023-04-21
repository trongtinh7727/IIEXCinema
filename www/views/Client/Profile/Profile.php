<div class="container">
    <div id="profile-main" class="my-5 p-3 text-white rounded-4">
        <h2 class="text-uppercase text-yellow text-center">Thông tin tài khoản</h2>
        <form action="./?updateprofile" method="post">
            <input type="hidden" name="ID" value="<?php echo $profile[0]['ID'] ?>">
            <table class="mx-auto">
                <!-- Username -->
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Tên đăng nhập:</td>
                    <td><input name="profile-username" value="<?php echo $profile[0]['USERNAME'] ?>" type="text" class="mx-3 rounded-3 text-white w-100" disabled></td>
                </tr>
                <!-- Name -->
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Họ:</td>
                    <td><input name="FIRSTNAME" value="<?php echo $profile[0]['FIRSTNAME'] ?>" type="text" class="mx-3 rounded-3 text-white w-100"></td>
                </tr>
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Tên:</td>
                    <td><input name="LASTNAME" value="<?php echo  $profile[0]['LASTNAME']  ?>" type="text" class="mx-3 rounded-3 text-white w-100"></td>
                </tr>
                <!-- Birthday -->
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Ngày sinh:</td>
                    <td><input name="BIRTHDAY" value="<?php echo $profile[0]['BIRTHDAY'] ?>" type="date" class="mx-3 rounded-3 text-white w-100"></td>
                </tr>
                <!-- Gender -->
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Giới tính:</td>
                    <td class="d-flex align-items-center">
                        <!-- Male -->
                        <input name="SEX" id="SEX-male" type="radio" value="Nam" <?php if ($profile[0]['SEX'] == 'Nam') echo 'checked'; ?> class="ms-3 me-1 rounded-3 text-white">
                        <label for="SEX-male">Nam</label>
                        <!-- Female -->
                        <input name="SEX" id="SEX-female" type="radio" value="Nữ" <?php if ($profile[0]['SEX'] == 'Nữ') echo 'checked'; ?> class="ms-3 me-1 rounded-3 text-white">
                        <label for="SEX-female">Nữ</label>
                    </td>
                </tr>
                <!-- Address -->
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Địa chỉ:</td>
                    <td><input name="ADDRESS" value="<?php echo $profile[0]['ADDRESS'] ?>" type="text" class="mx-3 rounded-3 text-white w-100"></td>
                </tr>
                <!-- Phone -->
                <tr style="height: 44px;">
                    <td class="text-end fw-medium">Điện thoại:</td>
                    <td><input name="PHONE" type="tel" value="<?php echo $profile[0]['PHONE'] ?>" class="mx-3 rounded-3 text-white w-100"></td>
                </tr>

                <tr style="height: 44px;">
                    <td></td>
                    <td class="text-end">
                        <input type="submit" class="mx-3 px-3 rounded-3 bg-yellow hover-bg-green border-0 fw-medium" value="Xác nhận">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php if (isset($_GET['success'])) : ?>
        <div class="alert alert-success"><?php echo "Cập nhật thành công"; ?></div>
    <?php elseif (isset($_GET['error'])) : ?>
        <div class="alert alert-danger"><?php echo "Cập nhật thất bại"; ?></div>
    <?php endif; ?>
</div>