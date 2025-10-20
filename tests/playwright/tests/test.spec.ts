import {test, expect} from '@playwright/test';

test('homepage has Playwright in title and get started link works', async ({page}) => {
  // Navigate to the Playwright homepage
  await page.goto('https://1987haus-master-tc11x2.laravel.cloud/shop/');

  await page.getByRole('link', { name: 'เข้าสู่ระบบ', exact: true }).click();
  await page.getByRole('textbox', { name: 'Email' }).click();
  await page.getByRole('textbox', { name: 'Email' }).fill('123@email.com');
  await page.getByRole('textbox', { name: 'รหัสผ่าน' }).click();
  await page.getByRole('textbox', { name: 'รหัสผ่าน' }).fill('12345678');
  await page.getByRole('button', { name: 'เข้าสู่ระบบ' }).click();
  await page.getByLabel('Haus').getByRole('link', { name: 'สินค้า', exact: true }).click();
  await page.getByRole('link', { name: 'Hot Coffee' }).click();
  await page.getByRole('button', { name: '+' }).nth(1).click();
  await page.getByRole('button', { name: 'เพิ่มลงตะกร้า' }).nth(1).click();
  await page.getByRole('link', { name: 'items in cart' }).click();
  await page.getByRole('button', { name: 'ลบ' }).click();
  await page.goto('https://1987haus-master-tc11x2.laravel.cloud/cart');
  await page.getByRole('button', { name: 'test test' }).click();
  await page.getByRole('link', { name: 'ข้อมูลส่วนตัว' }).click();
  await page.getByRole('button', { name: 'ออกจากระบบ' }).click();

  await page.waitForTimeout(5000);

  // Verify that the page title contains "Playwright"
  await expect(page).toHaveTitle(/1987 Haus/);
});